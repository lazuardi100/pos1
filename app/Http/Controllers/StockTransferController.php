<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use App\Models\StockTransferHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use stdClass;

class StockTransferController extends Controller
{
    private $cache_time = 10 * 60;

    public function index(){
        $histories = StockTransferHistory::orderBy('created_at', 'desc')->get();

        $woo_products = (array) $this->woocommerce()->get('products');
        $shopify = new ShopifyHelper();
        $shopify_products = $shopify->getProducts();
        $shopify_products_stocks = $this->accumulate_stock_shopify($shopify_products);
        // dd($shopify_products_stocks, $woo_products);
        $all_stocks = $this->grouping_product($shopify_products_stocks, $woo_products);
        return view('dashboard.transfer_product.index', [
            'histories' => $histories,
            'all_stocks' => $this->order_by_total_stock($all_stocks),
        ]);
    }

    private function order_by_total_stock($products){
        $total_stocks = [];
        foreach ($products as $product) {
            $total_stocks[] = $product->shopify_stock + $product->woo_stock;
        }
        array_multisort($total_stocks, SORT_ASC, $products);
        return $products;
    }

    private function grouping_product($shopify_products, $woo_products){
        $all_stocks = [];
        foreach ($shopify_products as $product) {
            $temp_data = new stdClass();
            $temp_data->title = $product->title;

            $temp_data->shopify_stock = $product->shopify_stock;
            $all_stocks[] = $temp_data;
        }

        foreach ($woo_products as $woo_product){
            $is_available = false;
            foreach ($all_stocks as $all_stock) {
                if ($woo_product->name == $all_stock->title) {
                    $is_available = true;
                    if(is_numeric($woo_product->stock_quantity)){
                        $all_stock->woo_stock = $woo_product->stock_quantity;
                    }else{
                        $all_stock->woo_stock = 0;
                    }
                    break;
                }else{
                    if (!isset($all_stock->woo_stock)){
                        $all_stock->woo_stock = 0;
                    }
                }
                
            }
            if(!$is_available){
                $temp_data = new stdClass();
                $temp_data->title = $woo_product->name;
                if(is_numeric($woo_product->stock_quantity)){
                    $temp_data->woo_stock = $woo_product->stock_quantity;
                }else{
                    $temp_data->woo_stock = 0;
                }
                $temp_data->shopify_stock = 0;
                $all_stocks[] = $temp_data;
            }
        }
        // dd($all_stocks);
        return $all_stocks;
    }

    private function accumulate_stock_shopify($products){
        $final_products = [];
        foreach ($products as $product) {
            $temp_data = new stdClass();
            $temp_data->id = $product->id;
            $temp_data->title = $product->title;
            $stocks = 0;
            foreach ($product->variants as $variant) {
                if (is_numeric($variant->inventory_quantity)) {
                    $stocks += $variant->inventory_quantity;
                }
            }
            $temp_data->shopify_stock = $stocks;
            $final_products[] = $temp_data;
        }
        return $final_products;
    }

    public function from_woo(){
        $products = $this->woocommerce()->get('products');
        
        return view('dashboard.transfer_product.from_woo', compact('products'));
    }

    public function from_shopify(){
        $shopify = new ShopifyHelper();
        $products = $shopify->getProducts();
        // dd($products);
        return view('dashboard.transfer_product.from_shopify', compact('products'));
    }

    public function from_woo_detail($id){
        $product = $this->woo_product($id);
        
        $shopify = new ShopifyHelper();
        $shopify_products = $shopify->getProducts();

        $is_available = false;
        $same_product = null;

        foreach ($shopify_products as $shopify_product) {
            if ($shopify_product->title == $product->name) {
                $is_available = true;
                $same_product = $shopify_product;
                break;
            }
        }

        if (!$is_available) {
            return redirect()->back()->with('error', 'Product not available in Shopify');
        }
        // dd($same_product);
        return view('dashboard.transfer_product.from_woo_detail', [
            'product' => $product,
            'shopify_product' => $same_product,
        ]);
    }

    public function from_shopify_detail($id){
        $shopify = new ShopifyHelper();
        $product = $shopify->getProduct($id);
        
        $woo_products = $this->woocommerce()->get('products');
        $stock = 0;

        $is_available = false;
        $same_product = null;

        foreach ($woo_products as $woo_product) {
            if ($woo_product->name == $product->title) {
                $is_available = true;
                $same_product = $woo_product;
                break;
            }
        }

        foreach ($product->variants as $variant) {
            $stock += $variant->inventory_quantity;
        }

        if ($stock == 0) {
            return redirect()->back()->with('error', 'Product out of stock in Shopify');
        }

        if (!$is_available) {
            return redirect()->back()->with('error', 'Product not available in WooCommerce');
        }

        return view('dashboard.transfer_product.from_shopify_detail', [
            'product' => $product,
            'woo_product' => $same_product,
        ]);
    }

    public function from_woo_save(Request $request){
        // validation
        $request->validate([
            'woo_product_id' => 'required|integer',
            'shopify_variant_id' => 'required|integer',
            'quantity' => 'required|integer',
            'product_name' => 'required|string'
        ]);

        $woo_product_id = $request->woo_product_id;
        $shopify_variant_id = $request->shopify_variant_id;
        $quantity = $request->quantity;
        $product_name = $request->product_name;

        $woo_product = $this->woo_product($woo_product_id);

        $new_woo_product_qty = $woo_product->stock_quantity - $quantity;

        $shopify_helper = new ShopifyHelper();
        $shopify_variant = $shopify_helper->getVariant($shopify_variant_id);
        
        $error = [];
        $response = $shopify_helper->shopifyPost('inventory_levels/adjust.json', [
            'location_id' => 78386299153,
            'inventory_item_id' => $shopify_variant->inventory_item_id,
            'available_adjustment' => $quantity,
        ]);
        
        if (!$response->successful()) {
            $error[] = $response->body();
        }

        $is_success = true;
        if (count($error) > 0) {
            Log::error('Error while updating SKU in Shopify', $error);
            $is_success = false;
        }

        $data_woo = [
            'stock_quantity' => $new_woo_product_qty,
        ];

        $response = $this->woocommerce()->put('products/'.$woo_product_id, $data_woo);

        StockTransferHistory::create([
            'product_name' => $product_name,
            'quantity' => $quantity,
            'is_success' => $is_success,
            'transfer_type' => 'from_woo_to_shopify',
        ]);
        return redirect()->route('transfer_product.from_woo')->with('success', 'Product transferred successfully');
    }

    public function from_shopify_save(Request $request){
        $request->validate([
            'shopify_variant_id' => 'required|string',
            'quantity' => 'required|integer',
            'woo_product_id' => 'required|integer',
            'product_name' => 'required|string'
        ]);

        $shopify_inventory_item_id = explode('|', $request->shopify_variant_id)[0];
        $quantity = $request->quantity;
        $woo_product_id = $request->woo_product_id;
        $shopify_helper = new ShopifyHelper();
        $product_name = $request->product_name;
        $shopify_product_id = $request->shopify_product_id;

        $update_shopify_stock = $shopify_helper->shopifyPost('inventory_levels/adjust.json', [
            'location_id' => 78386299153,
            'inventory_item_id' => (int) $shopify_inventory_item_id,
            'available_adjustment' => $quantity * -1,
        ]);

        $is_success = true;

        if (!$update_shopify_stock->successful()) {
            Log::error('Error while updating SKU in Shopify', [$update_shopify_stock->body()]);
            $is_success = false;
        }else{
            $woo_product = $this->woocommerce()->get('products/'.$woo_product_id);
            $woo_stock = $woo_product->stock_quantity + $quantity;
            $this->woocommerce()->put('products/'.$woo_product_id, [
                'stock_quantity' => $woo_stock,
            ]);
        }

        StockTransferHistory::create([
            'product_name' => $product_name,
            'quantity' => $quantity,
            'is_success' => $is_success,
            'transfer_type' => 'from_shopify_to_woo'
        ]);
        return redirect()->route('transfer_product.from_shopify')->with('success', 'Product transferred successfully');
    }

    private function woo_product($id){
        $product = $this->woocommerce()->get('products/'.$id);

        return $product;
    }
}

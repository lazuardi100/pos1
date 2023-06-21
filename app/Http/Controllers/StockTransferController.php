<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockTransferController extends Controller
{
    private $cache_time = 10 * 60;

    public function from_woo(){
        if (Cache::has('all_products_woo')) {
            $products = Cache::get('all_products_woo');
        } else {
            $products = $this->woocommerce()->get('products');
            Cache::put('all_products_woo', $products, $this->cache_time);
        }
        
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
            'size' => 'required|string',
        ]);

        $woo_product_id = $request->woo_product_id;
        $shopify_variant_id = $request->shopify_variant_id;
        $quantity = $request->quantity;

        $woo_product = $this->woo_product($woo_product_id);

        $new_woo_product_qty = $woo_product->stock_quantity - $quantity;

        $shopify_helper = new ShopifyHelper();
        $shopify_variant = $shopify_helper->getVariant($shopify_variant_id);
        // dd($shopify_variant);
        $error = [];
        $response = $shopify_helper->shopifyPost('inventory_levels/adjust.json', [
            'location_id' => 78386299153,
            'inventory_item_id' => $shopify_variant->inventory_item_id,
            'available_adjustment' => $quantity,
        ]);
        
        if (!$response->successful()) {
            $error[] = $response->body();
        }

        Log::info('Shopify response', $response->json());
        if (count($error) > 0) {
            Log::error('Error while updating SKU in Shopify', $error);
        }

        $data_woo = [
            'stock_quantity' => $new_woo_product_qty,
        ];

        $response = $this->woocommerce()->put('products/'.$woo_product_id, $data_woo);

        Cache::forget('product_detail_woo_'.$woo_product_id);
        return redirect()->route('transfer_product.from_woo')->with('success', 'Product transferred successfully');
    }

    private function woo_product($id){
        if (Cache::has('product_detail_woo_'.$id)) {
            $product = Cache::get('product_detail_woo_'.$id);
        } else {
            $product = $this->woocommerce()->get('products/'.$id);
            Cache::put('product_detail_woo_'.$id, $product, $this->cache_time);
        }

        return $product;
    }
}

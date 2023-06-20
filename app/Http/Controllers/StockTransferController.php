<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function from_woo_detail($id){
        if (Cache::has('product_detail_woo_'.$id)) {
            $product = Cache::get('product_detail_woo_'.$id);
        } else {
            $product = $this->woocommerce()->get('products/'.$id);
            Cache::put('product_detail_woo_'.$id, $product, $this->cache_time);
        }

        if ($product->stock_quantity == 0 || $product->stock_quantity == null) {
            Cache::forget('product_detail_woo_'.$id);
            return redirect()->back()->with('error', 'Product '.$product->name.' out of stock');
        }
        
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
}

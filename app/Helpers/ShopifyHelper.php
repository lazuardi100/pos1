<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShopifyHelper{

  private $cache_time = 10 * 60;
  private $url = 'https://theblotter-room-8686.myshopify.com/admin/api/2023-04/';

  public function shopifyGet(String $endpoint, Array $params = []){
    return Http::withHeaders([
        'X-Shopify-Access-Token' => env('SHOPIFY_API_KEY')
    ])->get($this->url . $endpoint, $params);
  }

  public function shopifyPost(String $endpoint, Array $params = []){
    return Http::withHeaders([
        'X-Shopify-Access-Token' => env('SHOPIFY_API_KEY')
    ])->post($this->url . $endpoint, $params);
  }

  public function shopifyPut(String $endpoint, Array $params = []){
    return Http::withHeaders([
        'X-Shopify-Access-Token' => env('SHOPIFY_API_KEY'),
        'Content-Type' => 'application/json'
    ])->put($this->url . $endpoint, $params);
  }

  public function getProducts(){
    if (Cache::has('products_shopify')) {
      $products = Cache::get('products_shopify');
    } else {
        $products = json_decode($this->shopifyGet('products.json')->body())->products;
        Cache::put('products_shopify', $products, $this->cache_time);
    }

    return $products;
  }

  public function getProduct($id){
    if (Cache::has('product_shopify_' . $id)) {
      $product = Cache::get('product_shopify_' . $id);
    } else {
        $product = json_decode($this->shopifyGet('products/' . $id . '.json')->body())->product;
        Cache::put('product_shopify_' . $id, $product, $this->cache_time);
    }

    return $product;
  }

  public function getVariant($id){
    if (Cache::has('variant_shopify_' . $id)) {
      $variant = Cache::get('variant_shopify_' . $id);
    } else {
        $variant = json_decode($this->shopifyGet('variants/' . $id . '.json')->body())->variant;
        Cache::put('variant_shopify_' . $id, $variant, $this->cache_time);
    }

    return $variant;
  }
}
?>
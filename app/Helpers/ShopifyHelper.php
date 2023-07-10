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
    $products = json_decode($this->shopifyGet('products.json')->body())->products;

    return $products;
  }

  public function getProduct($id){
    $product = json_decode($this->shopifyGet('products/' . $id . '.json')->body())->product;

    return $product;
  }

  public function getVariant($id){
    $variant = json_decode($this->shopifyGet('variants/' . $id . '.json')->body())->variant;

    return $variant;
  }
}
?>
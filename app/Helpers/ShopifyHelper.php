<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShopifyHelper{
  public function shopifyGet(String $endpoint, Array $params = []){
    return Http::withHeaders([
        'X-Shopify-Access-Token' => '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'
    ])->get('https://theblotter-room.com/admin/api/2023-04/' . $endpoint, $params);
  }

  public function shopifyPost(String $endpoint, Array $params = []){
    return Http::withHeaders([
        'X-Shopify-Access-Token' => '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'
    ])->post('https://theblotter-room.com/admin/api/2023-04/' . $endpoint, $params);
  }

  public function getProducts(){
    if (Cache::has('products')) {
      $products = Cache::get('products');
    } else {
        $products = json_decode($this->shopifyGet('products.json')->body())->products;
        Cache::put('products', $products, 10 * 60);
    }

    return $products;
  }

  public function getProduct($id){
    if (Cache::has('product_' . $id)) {
      $product = Cache::get('product_' . $id);
    } else {
        $product = json_decode($this->shopifyGet('products/' . $id . '.json')->body())->product;
        Cache::put('product_' . $id, $product, 10 * 60);
    }

    return $product;
  }
}
?>
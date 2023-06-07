<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use Illuminate\Http\Request;

class GlobalProductController extends Controller
{
    public function save(Request $request){
      // validate
      $request->validate([
        'product_name' => 'required|string',
        'product_description' => 'required|string',
      ]);

      $name = $request->product_name;
      $description = $request->product_description;
      // dd($request->has('woo_save'));
      if($request->has('woo_save')){
        $this->save_to_woo($name, $description);
      }

      if($request->has('shopify_save')){
        $this->save_to_shopify($name, $description);
      }

      return view('dashboard.global_product.index', [
        'name' => $name,
        'description' => $description,
      ]);
    }

    private function save_to_woo(String $name, String $description){
      $data = [
        'name' => $name,
        'type' => 'simple',
        'description' => $description,
      ];

      try {
        $this->woocommerce()->post('products', $data);
      } catch (\Throwable $th) {
      }
    }

    private function save_to_shopify(String $name, String $description){
      $data = [
        'product' => [
          'title' => $name,
          'body_html' => $description,
          'vendor' => 'Global Product',
          'product_type' => 'Global Product',
        ]
      ];

      $shopify_helper = new ShopifyHelper();

      $shopify_helper->shopifyPost('products.json', $data);
    }
}

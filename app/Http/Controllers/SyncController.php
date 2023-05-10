<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function sync()
    {
        // Sync data from woocommerce to shopify
        // $this->syncProduct();
        $this->syncCustomers();
    }

    private function syncProduct()
    {
        $products_from_woo = $this->woocommerce()->get('products');
        $products_from_shopify = json_decode($this->shopifyGet('products.json')->body());

        $unavailable_products_on_shopify = [];

        foreach ($products_from_woo as $product_woo) {
            // find product name on shopify
            $product_on_shopify = collect($products_from_shopify->products)->where('title', $product_woo->name)->first();

            // insert product if not found
            if ($product_on_shopify) {
                $unavailable_products_on_shopify[] = $product_woo->name;
            }
        }

        dd($unavailable_products_on_shopify);
    }

    public function syncCustomers(){
        $customers_from_woo = $this->woocommerce()->get('customers');
        $customers_from_shopify = json_decode($this->shopifyGet('customers.json')->body());

        $unavailable_customers_on_shopify = [];

        foreach ($customers_from_woo as $customer_woo) {
            // find customer name on shopify
            $customer_on_shopify = collect($customers_from_shopify->customers)->where('first_name', $customer_woo->first_name)->first();

            // insert customer if not found
            if (!$customer_on_shopify) {
                $unavailable_customers_on_shopify[] = $customer_woo->first_name;
            }
        }

        dd($unavailable_customers_on_shopify);
    }
}

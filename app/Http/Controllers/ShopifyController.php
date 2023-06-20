<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ShopifyController extends Controller
{
    public function index(Request $request){
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }

        // check cache
        $shopify = new ShopifyHelper();
        $products = $shopify->getProducts();
        // dd($products);
        // paginate products
        $array = new Paginator($products, 10, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
        // dd($array);
        return view('dashboard.shopify.products.index', [
            'products' => $array,
            'convert' => $this->convertUSD()
        ]);
    }
}

<?php

namespace App\Http\Controllers\Woo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class StockController extends Controller
{
    public function index(Request $request){
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }

        $woocommerce = $this->woocommerce();
        $params = [
            'page' => $page,
        ];

        if($request->search != null){
            $params['search'] = $request->search;
        }
        $array = $woocommerce->get('products', $params);

        $a = $woocommerce->http->getResponse();
        $headers = $a->getHeaders();
        if (app()->environment('local')) {
            $totalPages = $headers['X-WP-TotalPages'];
            $total = $headers['X-WP-Total'];
        } else {
            $totalPages = $headers['x-wp-totalpages'];
            $total = $headers['x-wp-total'];
        }

        $array = new Paginator($array, $total, '10', $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // dd($array);
        return view('dashboard.stock.index', [
            "products" => $array
        ]);
    }

    public function show($id){
        $woocommerce = $this->woocommerce();
        $product = $woocommerce->get('products/'.$id);
        return view('dashboard.stock.show', [
            "product" => $product
        ]);
    }

    public function update(Request $request){
        $woocommerce = $this->woocommerce();
        $data = [
            'manage_stock' => true,
            'stock_quantity' => (int)$request->stock_quantity,
            'stock_status' => $request->stock_status
        ];

        $woocommerce->put('products/'.$request->product_id, $data);
        return redirect()->route('products.stock.index');
    }

    public function variant($id){
        $woocommerce = $this->woocommerce();
        $variations = $woocommerce->get('products/'.$id.'/variations');
        $product = $woocommerce->get('products/'.$id);
        return view('dashboard.stock.variant.index', [
            "variations" => $variations,
            "product" => $product
        ]);
    }

    public function variantShow($id, $variant_id){
        $woocommerce = $this->woocommerce();
        $variation = $woocommerce->get('products/'.$id.'/variations/'.$variant_id);
        $product = $woocommerce->get('products/'.$id);
        return view('dashboard.stock.variant.show', [
            "variation" => $variation,
            "product" => $product
        ]);
    }

    public function variantUpdate(Request $request){
        $woocommerce = $this->woocommerce();
        $data = [
            'manage_stock' => true,
            'stock_quantity' => (int)$request->stock_quantity,
            'stock_status' => $request->stock_status
        ];

        $woocommerce->put('products/'.$request->product_id.'/variations/'.$request->variation_id, $data);
        return redirect()->route('products.stock.variant.index', $request->product_id);
    }
}

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
}

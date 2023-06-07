<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Transaction;
use Automattic\WooCommerce\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function transaction(){
        // $woocommerce = $this->woocommerce();
        // // dd($woocommerce->get('customers'));
        // dd($woocommerce->delete('customers/6', ['force' => true]));
        $data = Transaction::with(['customers','carts'])->orderBy('created_at','desc')->get();

        // dd($data);
        view()->share([
            'data' => $data
        ]);

        return view('dashboard.transaction');
    }
    public function deleteCart($id){
        $data = cart::find($id);

        $data->delete();

        return redirect()->back();
    }
    public function printLabel($type,$id){
        return view('dashboard.printLabel');

    }

    public function showCustomer (){
        dd($this->customer());
    }

    public function hold (Request $request){

        $cartss = $this->cart();

        $tmp = [];
        $i = 0;

        $customer_id = '';
        $data = new Transaction();
        foreach ($cartss as $crt ){
            $crt->status = '0';
            $crt->customer_id = $request->customer_id;

            $customer_id = $request->customer_id;
            $crt->save();
        }

        $data->customer_id = $customer_id;
        $data->customer_id = $customer_id;

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function printInvoice ($id){
        $data = Transaction::with(['customers'])->whereId($id)->first();

        $carts = cart::where('transaction_id','=',$id)->get();

        $tmp = 0;
        foreach ($carts as $a){
            $tmp = $tmp + $a->subTotal;
        }

        view()->share([
            'carts' => $carts,
            'data' => $data,
            'total' => $tmp
        ]);
        return view('dashboard.printInvoice');
    }

    public function printShipping ($id){

//        dd('dqw');

        $data = Transaction::with(['customers'])->whereId($id)->first();
        $woocommerce = $this->woocommerce();

        $customer =$woocommerce->get('customers/'.$data->customer_id);

        $shipping = (array) $customer->shipping;
//        dd($shipping['address_1']);
        $carts = cart::where('transaction_id','=',$id)->get();

        $cs = Customer::where('customer_id','=',$data->customer_id)->first();

//        dd($cs);
        $tmp = 0;
        foreach ($carts as $a){
            $tmp = $tmp + $a->subTotal;
        }

        view()->share([
            'carts' => $carts,
            'data' => $data,
            'total' => $tmp,
            'shipping' => $shipping['address_1'],
            'cs' => $cs
        ]);
        return view('dashboard.printShipping');

    }

    public function customer (){
        $woocommerce = $this->woocommerce();

        $data = $woocommerce->get('customers');

        return $data;
    }

    public function createOrder(Request $request){
        $woocommerce = $this->woocommerce();

        $customer =$woocommerce->get('customers/'.$request->customer_id);

        $carts = $this->cart();

        $tmp = [];
        $i = 0;
        foreach ($carts as $cart ){

            if ($cart->variant_id == null){
                $tmp[$i++] = [
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->qty
                ];
            }else{
                $tmp[$i++] = [
                    'product_id' => $cart->product_id,
                    'variation_id' => $cart->variant_id,
                    'quantity' => $cart->qty
                ];
            }

        }

        $data = [
            'payment_method' => 'cash',
            'payment_method_title' => 'cash',
            'set_paid' => true,
            'billing' => [
                'first_name' => $customer->billing->first_name,
                'last_name' => $customer->billing->last_name,
                'address_1' => $customer->billing->address_1,
                'country' => $customer->billing->country,
                'email' => $customer->billing->email,
                'phone' =>  $customer->billing->phone
            ],
            'shipping' => [
                'first_name' => $customer->billing->first_name,
                'last_name' => $customer->billing->last_name,
                'address_1' => $customer->billing->address_1,
                'country' => $customer->billing->country,
            ],
            'line_items' => $tmp,
            'shipping_lines' => [
                [
                    'method_id' => 'flat_rate',
                    'method_title' => 'Flat Rate',
                    'total' => (string) $this->total()
                ]
            ]
        ];

        $order = $woocommerce->post('orders', $data);

        $transaction = new Transaction();
        $transaction->customer_id = $request->customer_id;
        $transaction->order = $order->id;
        $transaction->amount_pay = $request->amount_pay;
        $transaction->note_pay = $request->note_pay;
        $transaction->hold = 'no';
        $transaction->save();

        $cartss = $this->cart();

        $tmp = [];
        $i = 0;
        foreach ($cartss as $crt ){
            $crt->status = '1';
            $crt->transaction_id = $transaction->id;

            $crt->save();
        }




        return response()->json([
            'order' => $order,
            'status' => 'success'
        ]);
    }


    public function createCustomer(Request $request){

//        dd($request->customer_discount);

        $PecahStr = explode(" ", $request->customer_name);

        $as = $request->customer_name;
        $frist = $PecahStr[0];

        unset($PecahStr[0]);

//        dd(count($PecahStr));
        $woocommerce = $this->woocommerce();

        $data = [
            'email' => $request->customer_email,
            'first_name' => $frist,
            'last_name' => implode(' ',$PecahStr),
//            'username' => 'john.doe',
            'billing' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => $request->customer_address,
                'country' => 'INA',
                'email' => $request->customer_email,
                'phone' => '(555) 555-5555'
            ],
            'shipping' => [
                'first_name' => $frist,
                'last_name' => implode(' ',$PecahStr),
                'address_1' => $request->customer_address,
                'country' => 'INA',
                'email' => $request->customer_email,
                'phone' => $request->customer_phone
            ]
        ];



        $customer = $woocommerce->post('customers', $data);


        $cs = new Customer();
        $cs->customer_id = $customer->id;
        $cs->name = $as;
        $cs->discount = $request->customer_discount;
        $cs->customer_track = $request->customer_track;

        $cs->save();

        return redirect()->back();

    }

    public function totalPrice(){


        return response()->json([
            'total' => $this->total()
        ]);
    }
    public function updateQty(Request $request){

        $id = $request->id;
        $data = cart::find($id);
        $data->qty = $request->qty;
        $data->subTotal = round($data->qty * $data->price,2);

        $data->save();

        return response()->json([
            'status' => 'success'
        ]);

    }

    public function actionCart($name,$price,$product_id,$variant_id = ''){


        $data = new cart();

        $data->name = $name;
        $data->qty = 1;
        $data->price = $price;
        $data->subTotal = $price;
        $data->status = '0';
        $data->user_id = Auth::user()->id;
        if ($variant_id != 'simple'){
            $data->variant_id = $variant_id;
        }
        $data->product_id = $product_id;
        $data->save();

        return redirect()->back();

    }

    public function pos (Request $request){

        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }
        $params = [
            'page' => $page,
        ];

        $woocommerce = $this->woocommerce();
        $array = $woocommerce->get('products', $params);


        $a = $woocommerce->http->getResponse();
        $headers = $a->getHeaders();
        $totalPages = $headers['X-WP-TotalPages'];
        $total = $headers['X-WP-Total'];
        // $current_page = '1';

        $array = new Paginator($array, $total, '10', $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // dd($array);
        //        dd($data);

        $discount = Discount::all();

        view()->share([
            'products' => $array,
            'carts' => $this->cart(),
            'count' => count($this->cart()),
            'total' => $this->total(),
            'customers' => $this->customer(),
            'discount' => $discount
        ]);

        return view('dashboard.pos');

    }
    public function posSearch(Request $request){
//        dd($request->search);
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }


        $woocommerce = $this->woocommerce();

        $array = $woocommerce->get('products?search=' . $request->search);


        $a = $woocommerce->http->getResponse();
        $headers = $a->getHeaders();
        $totalPages = $headers['x-wp-totalpages'];
        $total = $headers['x-wp-total'];
        // $current_page = '1';

        $array = new Paginator($array, $total, '10', $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $discount = Discount::all();
        // dd($array);
        //        dd($data);
        view()->share([
            'products' => $array,
            'carts' => $this->cart(),
            'count' => count($this->cart()),
            'total' => $this->total(),
            'customers' => $this->customer(),
            'discount' => $discount

        ]);

        return view('dashboard.pos');
    }

    public function holdView ($customer_id,Request $request){
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }

        $woocommerce = $this->woocommerce();
        $params = [
            'page' => $page,
        ];
        $array = $woocommerce->get('products', $params);

        $a = $woocommerce->http->getResponse();
        $headers = $a->getHeaders();
        $totalPages = $headers['X-WP-TotalPages'];
        $total = $headers['X-WP-Total'];
        // $current_page = '1';

        $array = new Paginator($array, $total, '10', $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // dd($array);
        //        dd($data);

        $carts = cart::whereStatus('0')->whereCustomerId($customer_id)->get();

        $discount = Discount::all();
        view()->share([
            'products' => $array,
            'carts' => $carts,
            'count' => count($this->cart()),
            'total' => $this->total(),
            'customers' => $this->customer(),
            'discount' => $discount

        ]);


        return view('dashboard.pos');

    }
    public function posVariable ($id,Request $request){
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }

        $woocommerce = $this->woocommerce();

        $array = $woocommerce->get('products/'.$id.'/variations');

//        dd($array);
        $a = $woocommerce->http->getResponse();
        $headers = $a->getHeaders();
        $totalPages = $headers['X-WP-TotalPages'];
        $total = $headers['X-WP-Total'];
        // $current_page = '1';

        $array = new Paginator($array, $total, '10', $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $get = $woocommerce->get('products/'.$id);
        // dd($array);
        //        dd($data);
        $discount = Discount::all();
        view()->share([
            'products' => $array,
            'get' => $get,
            'carts' => $this->cart(),
            'count' => count($this->cart()),
            'total' => $this->total(),
            'customers' => $this->customer(),
            'discount' => $discount

        ]);


        return view('dashboard.posVariable');

    }

    public function index($filter = '')
    {
        $expense = Expense::all();

        $tmpExpense = 0;
//        $q = 0;

        foreach ($expense as $x){
            $tmpExpense = $tmpExpense + $x->price;
        }

        $modal = Product::all();
        $tmpModal = 0;

        foreach ($modal as $s){
            $tmpModal = $tmpModal + $s->price_sale;
        }

//        dd($tmpModal);

        $dt = Carbon::now();
        $now = $dt->toDateString();

//        dd($filter);
        if ($filter == ''){
            $query = [
//                'date_min' => '2016-05-01',
//                'date_max' => '2016-05-04'
            ];
        }elseif ($filter == 'yesterday'){

            $yesterday = Carbon::yesterday();

            $query = [
                'date_min' => $yesterday->toDateString(),
                'date_max' => $yesterday->toDateString()
            ];
        }elseif ($filter == 'last7day'){

            $asd = $dt->subDays(7);
            $query = [
                'date_min' => $asd->toDateString(),
                'date_max' => $now
            ];
        }elseif ($filter == 'last30day'){
            $asd = $dt->subDays(30);
            $query = [
                'date_min' => $asd->toDateString(),
                'date_max' => $now
            ];
        }elseif ($filter == 'thisMonth'){

//            dd($dt->lastOfMonth()->toDateString());
//            $asd = $dt->subDays(30);
            $query = [
                'date_min' => $dt->firstOfMonth()->toDateString(),
                'date_max' => $dt->lastOfMonth()->toDateString()
            ];
        }
        $woocommerce = $this->woocommerce();

//        $query = [
//            '2016-05-03' => 'dwqd',
//            '2016-05-03' => 'dqwdqwdwq'
//        ];
//
//        for($a = 0; $a<=1;$a++){
//            echo $query['2016-05-03'];
//        }
//        return;



        $data = $woocommerce->get('reports/sales', $query);
//        $data = $woocommerce->get('reports/sales');
        $anjg = (array) $data[0];
        $totals = (array) $anjg['totals'];
        $date = array_keys($totals);
//            dd($anjg);

        $tmp = [];
        $u = 0;
        foreach ($totals as $total){
            $a = (array) $total;
//            echo $total->sales;
            $tmp[$u++] = $a;
        }
//        dd($tmp);
//        return;
//        dd($anjg['total_sales']);


        $net = ($anjg['total_sales'] - $tmpModal) - $tmpExpense;

//        dd($net);


        view()->share([
            'dates' => $date,
            'totals' => $totals,
            'data' => $anjg,
            'net' => $net
        ]);
        return view('dashboard.home');
    }

    //    public function (){
    //        return view('dashboard.home');
    //    }


    public function report(){
        $woocommerce = $this->woocommerce();

        $data = $woocommerce->get('reports/sales');
        dd($data);
    }
    public function getCategory()
    {
        dd($this->woocommerce()->get('products/categories'));
    }

    public function getOne()
    {
        dd($this->woocommerce()->get('products/1064'));
    }

    public function show(Request $request)
    {
        $woocommerce = $this->woocommerce();

        $array = $woocommerce->get('products?page=6');

//        $a = $woocommerce->http->getResponse();
//        $headers = $a->getHeaders();
//        $totalPages = $headers['x-wp-totalpages'];
//        $total = $headers['x-wp-total'];
//        $current_page = '1';
//
//        $array = new Paginator($array, $total, '10', $current_page, [
//            'path' => $request->url(),
//            'query' => $request->query(),
//        ]);

        dd($array);
    }

    public function showVarian()
    {
        dd($this->woocommerce()->get('products/526/variations'));
    }
    public function deleteVarian()
    {
        dd($this->woocommerce()->delete('products/877/variations/733', ['force' => true]));
    }
    public function createVarian()
    {

        $data = [
            'regular_price' => '10.00',
            'attributes' => [
                [
                    //                    'id' => 6,
                    'option' => 'black'
                ]
            ]

        ];

        dd($this->woocommerce()->post('products/1064/variations', $data));
    }
    public function updateProduct (){
        $woocommerce = $this->woocommerce();

        $data = [
            'type' => 'variable'
        ];

        dd($woocommerce->put('products/1064', $data));
    }
    public function create()
    {

        $data = [
            'name' => 'anjasss',
            'type' => 'simple',
            'regular_price' => '21.99',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 40
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                ]
            ]
        ];

        dd($this->woocommerce()->post('products', $data));

//        $woocommerce = $this->woocommerce();
//
//        $data = [
//            'name' => 'Ship Your Idea',
//            'type' => 'variable',
//            'regular_price' => '21.99',
//            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
//            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
//            'categories' => [
//                [
//                    'id' => 40
//                ],
//            ],
//            'images' => [
//                [
//                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_front.jpg'
//                ],
//                [
//                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_back.jpg'
//                ],
//                [
//                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_front.jpg'
//                ],
//                [
//                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_back.jpg'
//                ]
//            ],
//            'attributes' => [
//                [
////                    'id' => 6,
//                    'position' => 0,
//                    'visible' => false,
//                    'variation' => true,
//                    'options' => [
//                        'Black',
//                        'Green'
//                    ]
//                ],
//                [
//                    'name' => 'Size',
//                    'position' => 0,
//                    'visible' => true,
//                    'variation' => true,
//                    'options' => [
//                        'S',
//                        'M'
//                    ]
//                ]
//            ],
//            'default_attributes' => [
//                [
////                    'id' => 6,
//                    'option' => 'Black'
//                ],
//                [
//                    'name' => 'Size',
//                    'option' => 'S'
//                ]
//            ]
//        ];
//
//        dd($woocommerce->post('products', $data));
    }
    public function createOption (Request $request){


        $woocommerce = $this->woocommerce();

        $data  = array(
            'attributes' => array(
                array(
                    'name' => 'Color',
                    'position' => 0,
                    'visible' => true, // default: false
                    'variation' => true, // default: false
                    'options' => array(
                        'black',
                        'blue'
                    )
                ),
            )
        );

        dd($woocommerce->put('products/1064', $data));
    }

    public function createAttribute (Request $request)
    {
        $woocommerce = $this->woocommerce();

        $data = [
            'name' => 'linux',
            'type' => 'select',
            'has_archives' => true
        ];

        dd($woocommerce->post('products/attributes', $data));
    }
    public function showAttribute(){
        $woocommerce = $this->woocommerce();

        dd($woocommerce->get('products/attributes'));
//        dd($woocommerce->get('products/attributes/4/terms'));

    }
    public function order (){
            $woocommerce = $this->woocommerce();
            dd($woocommerce->get('orders'));


    }
    public function orderCart (){
            $woocommerce = $this->woocommerce();

        $data = [
            'payment_method' => 'cash',
            'payment_method_title' => 'cash',
            'set_paid' => true,
            'billing' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => '969 Market',
                'address_2' => '',
                'city' => 'San Francisco',
                'state' => 'CA',
                'postcode' => '94103',
                'country' => 'US',
                'email' => 'john.doe@example.com',
                'phone' => '(555) 555-5555'
            ],
            'shipping' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_1' => '969 Market',
                'address_2' => '',
                'city' => 'San Francisco',
                'state' => 'CA',
                'postcode' => '94103',
                'country' => 'US'
            ],
            'line_items' => [
                [
                    'product_id' => 1088,
                    'quantity' => 2
                ],
            ],
            'shipping_lines' => [
                [
                    'method_id' => 'flat_rate',
                    'method_title' => 'Flat Rate',
                    'total' => '1'
                ]
            ]
        ];

        dd($woocommerce->post('orders', $data));

    }

    public function getDiscount(Request $request){
        $data = Customer::whereCustomerId($request->customer_id)->first();
        $discount = 0;
        if ($data != null){
            $discount = (int) $data->discount;
        }

        return response()->json([
            'discount' => $discount
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Product;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;
use PhpExcelReader;
use Spreadsheet_Excel_Reader;

//use Spreadsheet_Excel_Reader;

require_once public_path('excel_reader.php');


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearLabel (){
        $data = Label::where('user_id','=',Auth::user()->id)->get();

        foreach ($data as $s){
            $s->delete();
        }


        return redirect()->back();

    }
    public function labelPrint(Request $request){
        $tmpData=[];
        $tmp=[];
        $as=0;
        $name = $request->name;
        $qty = $request->qty;
        $unit_pirce = $request->unit_pirce;
        $ssd = 0;
        foreach ($request->qty as $a){
            $a = (int)$a;
            for ($i = 0;$i<$a;$i++){
                $tmpData[$ssd] = $name[$as];
                $tmp[$ssd] =[
                    'qty' => $qty[$as],
                    'unit_pirce' =>$unit_pirce[$as]
                ];
                $ssd++;
            }
            $as++;
        }

        view()->share([
            'tmpData' =>$tmpData,
            'tmpas' => $tmp,
            'count' => count($tmpData),
            'convert' => $this->convertUSD()
        ]);
        return view('dashboard.printLabel');
    }

    public function actionLabel($id,$name,$price, Request $request){
        $data = new Label();
        $data->user_id = Auth::user()->id;
        $data->product_id = $id;
        $data->name = $name;
        $data->unit_pirce = $price;
        $data->save();

        return redirect()->back();

    }
    public function labelVariant (Request $request,$id){
        if ($request->page == null || $request->page == '') {
            $page = '1';
        } else {
            $page = $request->page;
        }

        $woocommerce = $this->woocommerce();

        $array = $woocommerce->get('products/'.$id.'/variations');

        $get = $woocommerce->get('products/'.$id);

        $a = $woocommerce->http->getResponse();

        $labels = Label::whereUserId(Auth::user()->id)->get();

        view()->share([
            'products' => $array,
            'labels' => $labels,
            'get' => $get
        ]);


        return view('dashboard.labelVariant');

    }
    public function label (Request $request){
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
        $labels = Label::whereUserId(Auth::user()->id)->get();

        view()->share([
            'products' => $array,
            'labels' => $labels
        ]);

        return view('dashboard.label');
    }

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
        view()->share([
            'products' => $array,
            'convert' => $this->convertUSD()
        ]);
        return view('dashboard.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        dd('dqw');
        $categories = $this->woocommerce()->get('products/categories');
        $tags = $this->woocommerce()->get('products/tags');
        $data = null;

        //        dd($categories);
        view()->share([
            'categories' => $categories,
            'tags' => $tags,
            'data' => $data
        ]);
        return view('dashboard.products.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $woocommerce = $this->woocommerce();
        $jenis_input = $request->jenis_input;
        $jumlah_input = $request->jumlah_input;
        $tmpUrl = [];
        $i= 0;
        if ($request->file('image')){
            $files = $request->file('image');
            foreach ($files as $file) {

                $name = rand(9999999, 1);
                $extension = $file->getClientOriginalExtension();
                $newName = $name . '.' . $extension;
                $input = 'upload/' . $newName;
                $file->move(public_path('upload'), $newName);
                $tmpUrl[$i++] = [
                    'src' => url($input)
                ];
            }
        }

        if ($request->type == '1'){
            $type = 'simple';

            $data = [
                'name' => $request->name,
                'type' => $type,
                'price' => $request->price,
                'regular_price' => $request->price,
                'short_description' => $request->dsc,
                'manage_stock' => 'true',
                'stock_quantity' => $request->quantity,
                'categories' => [
                    [
                        'id' => $request->category
                    ]
                ],
                'images' => [
                    [
                        'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                    ]
                ]
            ];

            $ls = $this->woocommerce()->post('products', $data);

        }else{

            $type = 'simple';

            $data = [
                'name' => $request->name,
                'type' => $type,
                'regular_price' => $request->price,
                'price' => $request->price,
                'description' => $request->dsc,
                'short_description' => $request->dsc,
                'manage_stock' => 'true',
                'stock_quantity' => (int)$request->quantity,
                'categories' => [
                    [
                        'id' => $request->category
                    ]
                ],
                'images' => [
                    [
                        'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                    ]
                ],
                'attributes' => array(
                    array(
                        'name' => 'Size',
                        'position' => 0,
                        'visible' => true, // default: false
                        'variation' => true, // default: false
                        'options' => $jenis_input
                    ),
                ),
            ];

            $ls = $this->woocommerce()->post('products', $data);

            $datas = [
                'type' => 'variable'
            ];

            $woocommerce->put('products/'.$ls ->id, $datas);

            $itung = count($request->jumlah_input);

//            dd($jenis_input);
            for ($i = 0 ; $i<$itung; $i++){

                $tmps = $jenis_input[$i];

                $sku = 'sku-0';
                if ($jenis_input[$i] = 's'){
                    $sku = 'sku-1';
                }elseif ($jenis_input[$i] = 'm'){
                    $sku = 'sku-2';
                }elseif ($jenis_input[$i] = 'l'){
                    $sku = 'sku-3';
                }elseif ($jenis_input[$i] = 'xl'){
                    $sku = 'sku-4';
                }elseif ($jenis_input[$i] = 'xxl'){
                    $sku = 'sku-5';
                }elseif ($jenis_input[$i] = 'xxxl'){
                    $sku = 'sku-6';
                }

                $dataVariant = [
                    'attributes' => [
                        [
                            'name' => 'Size' ,
                            'option' => $tmps
                        ]
                    ],
                    'regular_price' => $request->price,
                    'manage_stock' => 'true',
                    'stock_quantity' => (int) $jumlah_input[$i],
//                    'sku' => $sku
                ];
//                dd($dataVariant);

                $woocommerce->post('products/'.$ls->id.'/variations', $dataVariant);


//                sampe sini
            }


        }


        $new = new Product();

        $new->api_product_api = $ls->id;
        $new->price_modal = $request->price_modal;
        $new->price_sale = $request->price;
        $new->barcode = $request->barcode;
        $new->save();

        return redirect()->route('products.index')->with('success','success edit data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $woocommerce = $this->woocommerce();

        $data = $woocommerce->get('products/'.$id);

        $sql = Product::where('api_product_api','=',$id)->first();

        $categories = $this->woocommerce()->get('products/categories');
        $tags = $this->woocommerce()->get('products/tags');

        //        dd($categories);
        view()->share([
            'categories' => $categories,
            'tags' => $tags,
            'data' => $data,
            'sql' => $sql
        ]);
        return view('dashboard.products.form');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->type);
        $woocommerce = $this->woocommerce();

        $cek = $woocommerce->get('products/'.$id);;
        $type = $cek->type;
//        dd($cek);
        $jenis_input = $request->jenis_input;
        $jumlah_input = $request->jumlah_input;
        $tmpUrl = [];
        $i= 0;


        if ($request->file('image')){
            $files = $request->file('image');
            foreach ($files as $file) {

                $name = rand(9999999, 1);
                $extension = $file->getClientOriginalExtension();
                $newName = $name . '.' . $extension;
                $input = 'upload/' . $newName;
                $file->move(public_path('upload'), $newName);
                $tmpUrl[$i++] = [
                    'src' => url($input)
                ];
            }
        }


        if ( $type == 'simple'){
//            $type = 'simple';
//            dd($type);

            $data = [
                'name' => $request->name,
                'type' => $type,
                'price' => $request->price,
                'regular_price' => $request->price,
                'short_description' => $request->dsc,
                'manage_stock' => 'true',
                'stock_quantity' => $request->quantity,
                'categories' => [
                    [
                        'id' => $request->category
                    ]
                ],
                'images' => [
                    [
                        'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                    ]
                ]
            ];

//            dd($data);
//            $ls = $this->woocommerce()->post('products', $data);
            $ls = $this->woocommerce()->put('products/'.$id,$data);

        }
        else{

//            dd('dwq');


//            dd($type);

            $data = [
                'name' => $request->name,
                'type' => $type,
                'regular_price' => $request->price,
                'price' => $request->price,
                'description' => $request->dsc,
                'short_description' => $request->dsc,
                'manage_stock' => 'true',
                'stock_quantity' => (int)$request->quantity,
                'categories' => [
                    [
                        'id' => $request->category
                    ]
                ],
                'images' => [
                    [
                        'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                    ]
                ],
                'attributes' => array(
                    array(
                        'name' => 'Size',
                        'position' => 0,
                        'visible' => true, // default: false
                        'variation' => true, // default: false
                        'options' => $jenis_input
                    ),
                ),
//                'price_html' => '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>22</bdi></span>'
            ];


            $ls = $this->woocommerce()->post('products', $data);

//            dd($ls);

            $datas = [
                'type' => 'variable'
            ];

            $woocommerce->put('products/'.$ls ->id, $datas);
//            dd($woocommerce->put('products/'.$ls ->id, $datas));


            $itung = count($request->jumlah_input);

//            dd($jenis_input);
            for ($i = 0 ; $i<$itung; $i++){

                $tmps = $jenis_input[$i];

                $sku = 'sku-0';
                if ($jenis_input[$i] = 's'){
                    $sku = 'sku-1';
                }elseif ($jenis_input[$i] = 'm'){
                    $sku = 'sku-2';
                }elseif ($jenis_input[$i] = 'l'){
                    $sku = 'sku-3';
                }elseif ($jenis_input[$i] = 'xl'){
                    $sku = 'sku-4';
                }elseif ($jenis_input[$i] = 'xxl'){
                    $sku = 'sku-5';
                }elseif ($jenis_input[$i] = 'xxxl'){
                    $sku = 'sku-6';
                }

                $dataVariant = [
                    'attributes' => [
                        [
                            'name' => 'Size' ,
                            'option' => $tmps
                        ]
                    ],
                    'regular_price' => $request->price,
                    'manage_stock' => 'true',
                    'stock_quantity' => (int) $jumlah_input[$i],
//                    'sku' => $sku
                ];
//                dd($dataVariant);

                $woocommerce->post('products/'.$ls->id.'/variations', $dataVariant);


//                sampe sini
            }


        }


        $new = Product::where('api_product_api','=',$id)->first();

        $new->price_modal = $request->price_modal;
        $new->price_sale = $request->price;
        $new->barcode = $request->barcode;
        $new->save();

        return redirect()->route('products.index')->with('success','success edit data');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->woocommerce()->delete('products/' . $id, ['force' => true]);
        return redirect()->route('products.index');
    }

    public function import()
    {
//        dd('dwqdqw');
//        return;
                return view('dashboard.products.import');
    }

    public function importAction(Request $request){

        // menangkap file excel
//        $file = $request->file('file');
//
////        dd($file);
//        // membuat nama file unik
//        $nama_file = rand().$file->getClientOriginalName();
//
//        // upload ke folder file_siswa di dalam folder public
//        $file->move('file_import',$nama_file);

        $excel = new PhpExcelReader;
//        $excel->read(public_path('file_import/'.$nama_file)); //yg asli
        $excel->read(public_path('file_import/1499938663test.xls'));
//        dd($excel->sheets[0]);
        $sheet = $excel->sheets[0];
        $numRows = $sheet['numRows'];
        $numCols = 11;

        $starRows = 5;
        $sc = isset($sheet['cells'][3][13]) ? $sheet['cells'][3][13] : '';

        for ($z = 1; $z<=$sc;$z++){
            for ($i = $starRows;$i<=$numRows;$i++){
                $cekz = isset($sheet['cells'][$i][1]) ? $sheet['cells'][$i][1] : '';
//                dd($cekz);
                if ($z==$cekz){
                    for ($y = 1; $y<=$numCols;$y++){
                        $cell = isset($sheet['cells'][$i][$y]) ? $sheet['cells'][$i][$y] : '';
                        if ($cell == '' || $cell == null){
                            $cell = 'null';
                        }

                        //ngodingnya disini

                        echo $cell.' ';
                    }

                }
                echo '<br>';
            }
//            return;
        }



        return;
//        dd($numCols);
    }
}

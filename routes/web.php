<?php

use App\Http\Controllers\GlobalProductController;
use App\Http\Controllers\StockTransferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('s');


Auth::routes();

Route::get('/show', [\App\Http\Controllers\HomeController::class, 'show']);
Route::get('/showOne', [\App\Http\Controllers\HomeController::class, 'getOne']);
Route::get('/create', [\App\Http\Controllers\HomeController::class, 'create']);
Route::get('/updateProduct', [\App\Http\Controllers\HomeController::class, 'updateProduct']);
Route::get('/getCategory', [\App\Http\Controllers\HomeController::class, 'getCategory']);
Route::get('/createVarian', [\App\Http\Controllers\HomeController::class, 'createVarian']);
Route::get('/showVarian', [\App\Http\Controllers\HomeController::class, 'showVarian']);
Route::get('/createAttribute', [\App\Http\Controllers\HomeController::class, 'createAttribute']);
Route::get('/createOption', [\App\Http\Controllers\HomeController::class, 'createOption']);
Route::get('/order', [\App\Http\Controllers\HomeController::class, 'order']);
Route::get('/orderCart', [\App\Http\Controllers\HomeController::class, 'orderCart']);
Route::get('/order/destroy/{id}', [\App\Http\Controllers\HomeController::class, 'deleteCart'])->name('delete.cart');
Route::get('/customer', [\App\Http\Controllers\HomeController::class, 'showCustomer']);
Route::get('/report', [\App\Http\Controllers\HomeController::class, 'report']);
Route::get('/showAttribute', [\App\Http\Controllers\HomeController::class, 'showAttribute']);

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/pos', [App\Http\Controllers\HomeController::class, 'pos'])->name('pos');

    Route::post('/posSearch/', [App\Http\Controllers\HomeController::class, 'posSearch'])->name('pos.search');
    Route::get('/pos/variable/{id}', [App\Http\Controllers\HomeController::class, 'posVariable'])->name('posVariable');
    Route::get('/hold/{customer_id}', [App\Http\Controllers\HomeController::class, 'holdView'])->name('holdView');

    //Route::get('/expense', [App\Http\Controllers\HomeController::class, 'expense'])->name('expense');
    Route::get('/home/{filter}', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboardFilter');
    Route::get('actionCart/{name}/{price}/{product_id}/{variant_id}', [App\Http\Controllers\HomeController::class, 'actionCart'])->name('actionCart');

    Route::post('/updateQty', [\App\Http\Controllers\HomeController::class, 'updateQty'])->name('updateQty');
    Route::post('/getDiscount', [\App\Http\Controllers\HomeController::class, 'getDiscount']);

    Route::get('/totalPrice', [\App\Http\Controllers\HomeController::class, 'totalPrice'])->name('totalPrice');

    Route::post('/hold', [\App\Http\Controllers\HomeController::class, 'hold'])->name('hold');

    Route::post('/createCustomer', [\App\Http\Controllers\HomeController::class, 'createCustomer'])->name('createCustomer');
    Route::post('/createOrder', [\App\Http\Controllers\HomeController::class, 'createOrder'])->name('createOrder');

    Route::get('/printInvoice/{id}', [\App\Http\Controllers\HomeController::class, 'printInvoice'])->name('printInvoice');
    Route::get('/printShipping/{id}', [\App\Http\Controllers\HomeController::class, 'printShipping'])->name('printShipping');

    Route::get('/printLabel/{type}/{id}', [\App\Http\Controllers\HomeController::class, 'printLabel'])->name('printLabel');
    Route::get('/transaction', [\App\Http\Controllers\HomeController::class, 'transaction'])->name('transaction');

    //Route::group(['prefix'=>'products','as'=>'products.','middleware'=>'auth'], function(){
    Route::group(['prefix' => 'products', 'as' => 'products.', 'middleware' => 'auth'], function () {
        Route::get('/import', [App\Http\Controllers\ProductController::class, 'import'])->name('import');
        Route::post('/importAction', [App\Http\Controllers\ProductController::class, 'importAction'])->name('importAction');
        Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroys');
        Route::get('/a/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('create');
        Route::post('/a/create/post', [\App\Http\Controllers\ProductController::class, 'store'])->name('store');

        Route::get('/label', [App\Http\Controllers\ProductController::class, 'label'])->name('label');
        Route::get('/labelVariant/{id}', [App\Http\Controllers\ProductController::class, 'labelVariant'])->name('labelVariant');
        Route::get('/actionLabel/{id}/{name}/{price}', [App\Http\Controllers\ProductController::class, 'actionLabel'])->name('actionLabel');
        Route::post('/labelPrint', [App\Http\Controllers\ProductController::class, 'labelPrint'])->name('labelPrint');
        Route::get('/clear/label', [App\Http\Controllers\ProductController::class, 'clearLabel'])->name('clear.label');

        // Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'shopify', 'as' => 'shopify.', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'products', 'as' => 'products'], function(){
            Route::get('/', [App\Http\Controllers\ShopifyController::class, 'index'])->name('index');
        });
    });

    Route::group(['prefix'=> 'global_product', 'as'=>'global_product.', 'middleware'=>'auth'], function (){
        Route::get('/add', function(){
            return view('dashboard.global_product.index');
        })->name('index');

        Route::post('/save', [GlobalProductController::class, 'save'])->name('save');
    });

    Route::group(['prefix'=> 'transfer_product', 'as'=>'transfer_product.', 'middleware'=>'auth'], function (){
        Route::get('/', [StockTransferController::class, 'index'])->name('index');

        Route::get('/from_woo', [StockTransferController::class, 'from_woo'])->name('from_woo');
        Route::get('/from_shopify', [StockTransferController::class, 'from_shopify'])->name('from_shopify');
        Route::get('/from_woo/{id}', [StockTransferController::class, 'from_woo_detail'])->name('from_woo_detail');
        Route::get('/from_shopify/{id}', [StockTransferController::class, 'from_shopify_detail'])->name('from_shopify_detail');
        Route::post('/from_woo/save', [StockTransferController::class, 'from_woo_save'])->name('from_woo_save');
        Route::post('/from_shopify/save', [StockTransferController::class, 'from_shopify_save'])->name('from_shopify_save');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.', 'middleware' => 'auth'], function () {
        Route::get('/import', [App\Http\Controllers\CategoryController::class, 'import'])->name('import');
        Route::get('/{page}', [App\Http\Controllers\CategoryController::class, 'index'])->name('index');
        Route::get('/destroy/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('destroys');
        Route::get('/a/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controollers\CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('update');

        Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('index');
    });
    Route::get('expense/destroys/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expense.destroys');
    Route::resource('expense',\App\Http\Controllers\ExpenseController::class);

    Route::get('discount/destroys/{id}', [App\Http\Controllers\DiscountController::class, 'destroy'])->name('discount.destroys');
    Route::resource('discount',\App\Http\Controllers\DiscountController::class);

    Route::get('users/destroys/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroys');
    Route::resource('users',\App\Http\Controllers\UserController::class);
});


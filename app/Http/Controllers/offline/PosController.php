<?php

namespace App\Http\Controllers\offline;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\Customer;
use App\Models\OfflineCart;
use App\Models\OfflineProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->search;
		$products = OfflineProduct::where('name', 'like', '%' . $search . '%')->paginate(10);
		$customers = Customer::all();
		$carts = OfflineCart::where('user_id' , Auth::user()->id)
			->where('is_checkout', 0)
			->get();

		return view('dashboard.offline.pos.index', [
			'products' => $products,
			'customers' => $customers,
			'carts' => $carts,
			'count' => $carts->count(),
			'total' => $carts->sum('subtotal')
		]);
	}
}

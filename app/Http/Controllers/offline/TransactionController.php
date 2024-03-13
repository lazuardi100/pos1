<?php

namespace App\Http\Controllers\offline;

use App\Http\Controllers\Controller;
use App\Models\OfflineCart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
	public function index()
	{
		$data = Transaction::join('offline_carts', 'offline_carts.transaction_id', '=', 'transactions.id')
			->select('transactions.*')
			->distinct()
			->orderBy('transactions.created_at', 'desc')
			->paginate(10);
			
		return view('dashboard.offline.transaction.index', [
			'data' => $data
		]);
	}

	public function show($id)
	{
		$transaction = Transaction::find($id);
		$carts = OfflineCart::where('transaction_id', $id)->get();
		$total = OfflineCart::where('transaction_id', $id)->sum('subtotal');
		return view('dashboard.offline.transaction.show', [
			'transaction' => $transaction,
			'carts' => $carts,
			'total' => $total
		]);
	}
}

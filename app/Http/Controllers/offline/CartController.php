<?php

namespace App\Http\Controllers\offline;

use App\Http\Controllers\Controller;
use App\Models\OfflineCart;
use App\Models\OfflineProduct;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CartController extends Controller
{
	public function add(Request $request)
	{
		$product = OfflineProduct::find($request->product_id);

		$existing_cart = OfflineCart::where('product_id', $request->product_id)
			->where('user_id', auth()->user()->id)
			->where('is_checkout', 0)
			->first();

		if ($existing_cart) {
			$existing_cart->increment('quantity');
			$existing_cart->update([
				'subtotal' => $existing_cart->quantity * $product->price
			]);
		} else {
			OfflineCart::create([
				'user_id' => auth()->user()->id,
				'product_id' => $request->product_id,
				'quantity' => 1,
				'subtotal' => $product->price,
				'product_name' => $product->name,
				'price' => $product->price,
				'customer_id' => null
			]);
		}

		return redirect()->back();
	}

	public function update_qty(Request $request)
	{
		$cart = OfflineCart::find($request->id);
		$cart->quantity = $request->qty;
		$cart->subtotal = $cart->price * $request->qty;
		$cart->save();

		return response()->json(['message' => 'Quantity updated']);
	}

	public function destroy($id)
	{
		OfflineCart::destroy($id);
		return redirect()->back();
	}

	public function update_customer(Request $request)
	{
		$cart = OfflineCart::where('user_id', auth()->user()->id)->get();
		foreach ($cart as $c) {
			$c->customer_id = $request->customer_id;
			$c->save();
		}

		return response()->json(['message' => 'Customer updated']);
	}

	public function create_order(Request $request)
	{
		$cart = OfflineCart::where('user_id', auth()->user()->id)
			->where('is_checkout', 0)
			->get();

		if ($cart->count() == 0) {
			return response()->json(['message' => 'Cart is empty']);
		}

		if ($cart[0]->customer_id == null) {
			return response()->json(['message' => 'Please select customer']);
		}

		foreach ($cart as $c) {
			$product = OfflineProduct::find($c->product_id);
			if ($product->stock < $c->quantity) {
				return response()->json(['message' => 'Stock ' . $product->name . ' tidak mencukupi']);
			}
		}

		$transaction = new Transaction();
		$transaction->customer_id = $cart[0]->customer_id;
		$transaction->amount_pay = $request->amount_pay;
		$transaction->note_pay = $request->note_pay;
		$transaction->save();

		foreach ($cart as $c) {
			$c->is_checkout = true;
			$c->transaction_id = $transaction->id;

			$product = OfflineProduct::find($c->product_id);
			$product->stock -= $c->quantity;
			$product->save();
			$c->save();
		}

		return response()->json(['message' => 'Order created']);
	}
}

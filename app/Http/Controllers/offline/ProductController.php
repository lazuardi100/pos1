<?php

namespace App\Http\Controllers\offline;

use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use App\Models\OfflineProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->search;
		$products = OfflineProduct::where('name', 'like', '%' . $search . '%')->paginate(10);

		return view('dashboard.offline.products.index', [
			'products' => $products
		]);
	}

	public function new()
	{
		$businessUnits = BusinessUnit::all();
		return view('dashboard.offline.products.new', [
			'businessUnits' => $businessUnits
		]);
	}

	public function create(Request $request){
		// save image
		$image = $request->file('image');
		$imageName = time() . '.' . $image->extension();
		$image->move(public_path('offline_products_images'), $imageName);

		$product = new OfflineProduct();
		$product->name = $request->name;
		$product->sku = $request->sku;
		$product->price = $request->price;
		$product->stock = $request->stock;
		$product->description = $request->description;
		$product->business_unit_id = $request->business_unit_id;
		$product->image = $imageName;
		$product->save();

		return redirect()->route('offline.products.index');
	}

	public function show($id)
	{
		$product = OfflineProduct::find($id);
		$businessUnits = BusinessUnit::all();
		return view('dashboard.offline.products.show', [
			'product' => $product,
			'businessUnits' => $businessUnits
		]);
	}

	public function update(Request $request)
	{
		$product = OfflineProduct::find($request->id);

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '.' . $image->extension();
			$image->move(public_path('offline_products_images'), $imageName);
			// remove old image
			$oldImage = $product->image;
			$oldImagePath = public_path('offline_products_images') . '/' . $oldImage;
			if (file_exists($oldImagePath)) {
				unlink($oldImagePath);
			}
			$product->image = $imageName;
		}

		$product->name = $request->name;
		$product->sku = $request->sku;
		$product->price = $request->price;
		$product->stock = $request->stock;
		$product->description = $request->description;
		$product->business_unit_id = $request->business_unit_id;
		$product->save();

		return redirect()->route('offline.products.index');
	}

	public function destroy($id)
	{
		$product = OfflineProduct::find($id);
		$image = $product->image;
		$imagePath = public_path('offline_products_images') . '/' . $image;
		if (file_exists($imagePath)) {
			unlink($imagePath);
		}
		$product->delete();
		return redirect()->route('offline.products.index');
	}
}

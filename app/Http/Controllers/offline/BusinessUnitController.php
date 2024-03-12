<?php

namespace App\Http\Controllers\offline;

use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->search;
		$businessUnits = BusinessUnit::where('name', 'like', '%' . $search . '%')->paginate(10);

		return view('dashboard.offline.business_units.index', [
			'businessUnits' => $businessUnits
		]);
	}

	public function create(Request $request)
	{
		$name = $request->name;
		$businessUnit = new BusinessUnit();
		$businessUnit->name = $name;
		$businessUnit->save();

		return redirect()->back();
	}

	public function show($id)
	{
		$businessUnit = BusinessUnit::find($id);
		return view('dashboard.offline.business_units.show', [
			'businessUnit' => $businessUnit
		]);
	}

	public function destroy($id)
	{
		$businessUnit = BusinessUnit::find($id);
		$businessUnit->delete();

		return redirect()->back();
	}

	public function update(Request $request)
	{
		$businessUnit = BusinessUnit::find($request->id);
		$businessUnit->name = $request->name;
		$businessUnit->save();

		return redirect()->route('offline.business_units.index');
	}
}

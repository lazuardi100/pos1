<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Expense::all();

        view()->share([
            'data' => $data,
        ]);
        return view('dashboard.expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = '';
        view()->share([
            'edit' => $edit
        ]);

        return view('dashboard.expenses.form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
//        $data = Expense::find($request->id);
        $data = new Expense();

        $data->name = $request->name;
        $data->price = $request->price;
        $data->save();


//        dd($request);
        return redirect()->route('expense.index')->with('success','success create data');
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
        $edit = 'yes';
//        $data = $this->woocommerce()->get('products/categories/'.$id);
        $data = Expense::find($id);
        view()->share([
            'edit' => $edit,
            'data' => $data
        ]);
        return view('dashboard.expenses.form');
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
        $data = Expense::find($id);

        $data->name = $request->name;
        $data->price = $request->price;
        $data->save();


//        dd($request);
        return redirect()->route('expense.index')->with('success','success create data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd($id);
        $data = Expense::find($id);

        $data->delete();

        return redirect()->route('expense.index')->with('success','success delete data');

    }
}

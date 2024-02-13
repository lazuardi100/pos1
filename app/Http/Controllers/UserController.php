<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();

        view()->share([
            'data' => $data,
        ]);
        return view('dashboard.users.index');
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

        return view('dashboard.users.form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
//        $data = Expense::find($request->id);
        $data = new User();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->level = $request->level;
        $data->save();


//        dd($request);
        return redirect()->route('users.index')->with('success','success create data');
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
        $data = User::find($id);
        view()->share([
            'edit' => $edit,
            'data' => $data
        ]);
        return view('dashboard.users.form');
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
        return redirect()->route('users.index')->with('success','success create data');
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
        $data = User::find($id);

        $data->delete();

        return redirect()->route('users.index')->with('success','success delete data');

    }
}

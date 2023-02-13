<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        dd($this->woocommerce()->get('products'));
        $data = $this->woocommerce()->get('products/categories');

//        dd($data);
        view()->share([
            'data' => $data
        ]);
        return view('dashboard.categories.index');
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
        return view('dashboard.categories.form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'name' => $request->name,
        ];

//        dd($request->name);

        try {
            $this->woocommerce()->post('products/categories', $data);

            return redirect()->route('categories.index')->with('success','success create data');
        } catch (\Exception $e) {
//            report($e);

            return redirect()->route('categories.create')->with('danger','fail create data');

        }

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
        $data = $this->woocommerce()->get('products/categories/'.$id);

        view()->share([
            'edit' => $edit,
            'data' => $data
        ]);
        return view('dashboard.categories.form');
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
//        dd($id);
        $data = [
            'name' => $request->name
        ];

        $this->woocommerce()->put('products/categories/'.$id, $data);

        return redirect()->route('categories.index')->with('success','success edit data');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->woocommerce()->delete('products/categories/'.$id, ['force' => true]);

        return redirect()->route('categories.index')->with('danger','success delete data');

    }
}

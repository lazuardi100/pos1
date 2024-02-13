@extends('adminlte::page')

@section('title', 'Stock')

@section('content')
    <h1>Hello world</h1>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Striped Full Width Table</h3>
            <br>
            {{-- select currency --}}
            <label for="">Select Currency</label>
            <select name="currency" id="currency" class="form-control" onchange="currencyChange()">
                <option value="IDR" {{Request::get('currency') == 'IDR' ? 'selected' : ''}}>
                    IDR
                </option>
                <option value="USD" {{Request::get('currency') == 'USD' ? 'selected' : ''}}>
                    USD
                </option>
            </select>

            {{-- search --}}
            <form action="{{route('products.stock.index')}}" method="get">
                <label for="">Search product</label>
                <div class="input-group">
                    <input type="search" name="search" class="form-control form-control" placeholder="Type your keywords here" value="{{Request::get('search')}}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>stock status</th>
                    <th>quantity</th>
                    <th>type</th>
                    <th>
                        Change stock
                    </th>

                </tr>
                </thead>
                <tbody>
                {{-- {{$i=1}}--}}
                @foreach($products as $product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->stock_status}}</td>
                        <td>{{$product->stock_quantity}}</td>
                        <td>{{$product->type}}</td>
                        <form action="" method="post">
                            <td>
                                <input type="number" name="stock" class="form-control" value="{{$product->stock_quantity}}">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success">Change</button>
                            </td>
                        </form>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
@extends('adminlte::page')

@section('title', 'Stock')

@section('content')
    <div class="card">
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
                        <td>
                            @if ($product->type == 'variable')
                                <a href="{{route('products.stock.variant.index', $product->id)}}" class="btn btn-primary">Variants</a>
                            @else
                                <a href="{{route('products.stock.show', $product->id)}}" class="btn btn-primary">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
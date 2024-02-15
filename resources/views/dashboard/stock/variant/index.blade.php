@extends('adminlte::page')

@section('title', 'Stock')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-center">Variants Stock for {{$product->name}}</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Variant</th>
                    <th>stock status</th>
                    <th>quantity</th>
                    <th>
                        Change stock
                    </th>

                </tr>
                </thead>
                <tbody>
                {{-- {{$i=1}}--}}
                    @foreach($variations as $variant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$variant->name}}</td>
                            <td>{{$variant->stock_status}}</td>
                            <td>{{$variant->stock_quantity}}</td>
                            <td>
                                <a href="{{route('products.stock.variant.show', [$product->id, $variant->id])}}" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
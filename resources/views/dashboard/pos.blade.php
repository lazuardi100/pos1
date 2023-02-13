@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}

@stop

@section('content')
<div class="row pt-2">
    <div class="col-md-3" style="background-color: white;  position: relative; height: 90vh">
        @include('layouts.cart')

    </div>
    <div class="col-md-9">

        <div class="container-fluid">
        <h2 class="text-center display-4">Search</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{route('pos.search')}}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Type your keywords here">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <center>
        <div class="row mt-4">
            @foreach($products as $product)

            <div class="col-md-4">
                <a href="{{($product->type == 'variable') ? route('posVariable',$product->id) : route('actionCart',[$product->name,$product->regular_price,$product->id,'simple'])}}">
                <div class="card" style="width: 15rem;">
                    <img class="card-img-top" src="{{$product->images[0]->src}}">
                    <div class="card-body">
                        <h5 class="card-title"> {{$product->type}} - {{$product->name}}</h5>
                    </div>
                </div>
                </a>
            </div>
            @endforeach

        </div>
            {{ $products->links('vendor.pagination.bootstrap-4') }}

        </center>

    </div>
</div>
@stop

@section('js')
@stop

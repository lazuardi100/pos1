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
        <center>
        <div class="row mt-4">
            @foreach($products as $product)
                <div class="col-md-4">
                    <a href="{{route('actionCart',[$get->name.' - '.$product->attributes[0]->option,$product->regular_price,$get->id,$product->id])}}">
                    <div class="card" style="width: 15rem;">
                        <img class="card-img-top" src="{{$get->images[0]->src}}">
                        <div class="card-body">
                            <h5 class="card-title"> {{$get->name}} - {{$product->attributes[0]->option}}</h5>
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

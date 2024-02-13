@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
        $('.customer_select').select2();
    });
</script>
@stop

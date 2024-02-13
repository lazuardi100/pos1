@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    a[disabled="true"] {
        pointer-events: none;
    }

    img[grayscale="true"] {
        filter: grayscale(100%);
    }
</style>

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
                <form action="{{route('pos')}}" method="get">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="{{Request::get('search')}}">
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
                <a 
                    href="{{($product->type == 'variable') ? route('posVariable',$product->id) : route('actionCart',[$product->name,$product->regular_price,$product->id,'simple'])}}"
                    disabled = "{{$product->stock_status != 'instock' ? 'true' : 'false'}}"
                >
                    <div class="card" style="width: 15rem;">
                        @if($product->stock_status != 'instock')
                            <div class="alert alert-danger" role="alert">
                                Out of stock
                            </div>
                        @endif
                        @if ($product->images != [])
                            <img 
                                class="card-img-top" 
                                src="{{$product->images[0]->src}}"
                                grayscale="{{$product->stock_status != 'instock' ? 'true' : 'false'}}"
                            >
                        @endif
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
        $('.customer_select').select2();
    });
</script>
@stop

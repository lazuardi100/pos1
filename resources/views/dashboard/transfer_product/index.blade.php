@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')  
<h1>Transfer product</h1>
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-12">
        <a href={{route('transfer_product.from_shopify')}}>
          <div class="card">
            <div class="card-body text-center">
              <i class="fab fa-shopify" style="font-size: 48px"></i>  
              <i class="fas fa-arrow-right" style="font-size: 30px"></i>
              <i class="fab fa-wordpress-simple" style="font-size: 48px"></i>
              <br>
              <br>
              Shopify to Woocommerce
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-12">
        <a href={{route('transfer_product.from_woo')}}>
          <div class="card">
            <div class="card-body text-center">
              <i class="fab fa-wordpress-simple" style="font-size: 48px"></i>
              <i class="fas fa-arrow-right" style="font-size: 30px"></i>
              <i class="fab fa-shopify" style="font-size: 48px"></i>  
              <br>
              <br>
              Woocommerce to Shopify
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
@endsection
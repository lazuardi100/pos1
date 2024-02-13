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
    <h1>Stock</h1>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <td>Nama</td>
            <td>Stock shopify</td>
            <td>Stock woocommerce</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_stocks as $product)
            <tr>
              <td>{{$product->title}}</td>
              <td>{{$product->shopify_stock}}</td>
              <td>{{$product->woo_stock}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <h1>History</h1>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Transfer Type</th>
            <th>Quantity</th>
            {{-- <th>Status</th> --}}
            <th>Transfer At</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($histories as $history)
            <tr>
              <td>{{$history->product_name}}</td>
              <td>{{$history->transfer_type}}</td>
              <td>{{$history->quantity}}</td>
              {{-- <td>{{$history->is_success}}</td> --}}
              <td>{{$history->created_at}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
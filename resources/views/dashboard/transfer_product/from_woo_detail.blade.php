@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Transfer product Woo to Shopify</h1>
@stop

@section('content')
  <div class="container">
    <form action="" method="post">
      @csrf
      <label class="form-label">Product Name</label>
      <input type="text" class="form-control" name="product_name" value="{{$product->name}}" readonly>
      <label class="form-label">Stock From Woo</label>
      <input type="text" class="form-control" name="stock_from_woo" value="{{$product->stock_quantity}}" readonly>
      <label class="form-label">Select shopify variant</label>
      <select class="form-control" name="shopify_variant_id" required>
        @foreach ($shopify_product->variants as $variant)
          <option value={{$variant->id}}>{{$variant->title}}</option>
        @endforeach
      </select>
      <label class="form-label">Stock To Shopify</label>
      <input type="number" class="form-control" name="stock_to_shopify" max={{$product->stock_quantity}} required>
      <button type="submit" class="btn btn-primary mt-3">
        Transfer
      </button>
    </form>
  </div>
@endsection
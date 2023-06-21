@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Transfer product Shopify to Woo</h1>
@stop

@section('content')
  <div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="post">
      @csrf
      <input type="hidden" name="shopify_product_id" value={{$product->id}}>
      
      <label class="form-label">Product Name</label>
      <input type="text" class="form-control" name="product_name" value="{{$product->title}}" readonly>
      
      <label class="form-label">Select Shopify Variant</label>
      <select class="form-control" name="shopify_variant_id" id="shopify_variant_id" onchange="changeStock()" required>
        @foreach ($product->variants as $variant)
          <option value={{$variant->id."|".$variant->inventory_quantity}}>{{$variant->title}}</option>
        @endforeach
      </select>
      
      <label class="form-label">Stock From Shopify</label>
      <input type="text" class="form-control" name="stock_from_shopify" value="{{$product->variants[0]->inventory_quantity}}" readonly>
      
      <label class="form-label">Stock To Woo</label>
      <input type="number" class="form-control" name="quantity" max={{$product->variants[0]->inventory_quantity}} required>
      
      <label class="form-label">Size</label>
      <select name="size" class="form-control" id="" required>
        <option value="0">XS</option>
        <option value="1">S</option>
        <option value="2">M</option>
        <option value="3">L</option>
        <option value="4">XL</option>
        <option value="5">XXL</option>
      </select>

      <button type="submit" class="btn btn-primary mt-3">
        Transfer
      </button>
    </form>
  </div>

  <script>
    function changeStock(){
      let selectedVariant = document.getElementById('shopify_variant_id');
      let stock = selectedVariant.value.split('|')[1];

      document.getElementsByName('stock_from_shopify')[0].value = stock;
      document.getElementsByName('quantity').max = stock;
    }
  </script>
@endsection
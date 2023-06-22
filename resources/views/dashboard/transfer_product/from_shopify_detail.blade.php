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

    <form action={{route('transfer_product.from_shopify_save')}} method="post">
      @csrf
      <input type="hidden" name="woo_product_id" value={{$woo_product->id}}>
      
      <label class="form-label">Product Name</label>
      <input type="text" class="form-control" name="product_name" value="{{$product->title}}" readonly>
      
      <label class="form-label">Select Shopify Variant</label>
      <select class="form-control" name="shopify_variant_id" id="shopify_variant_id" onchange="changeStock()" required>
        @foreach ($product->variants as $variant)
          <option value={{$variant->inventory_item_id."|".$variant->inventory_quantity}}>{{$variant->title}}</option>
        @endforeach
      </select>
      
      <label class="form-label">Stock From Shopify</label>
      <input type="text" class="form-control" name="stock_from_shopify" value="{{$product->variants[0]->inventory_quantity}}" readonly>
      
      <label class="form-label">Stock To Woo</label>
      <input type="number" class="form-control" name="quantity" max={{$product->variants[0]->inventory_quantity}} required>
      
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
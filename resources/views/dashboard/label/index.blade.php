@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')  
<h1>Print label</h1>
@stop

@section('content')
<form action={{route('label.print')}} method="post">
  @csrf
  <label for="">Select source</label>
  <select name="source" id="source" class="form-control" onchange="source_change()">
    <option value="" selected>Select source</option>
    <option value="woo">woocommerce</option>
    <option value="shopify" disabled>shopify</option>
  </select>

  <label for="">Select product</label>
  <select name="" id="products" class="form-control" disabled onchange="product_change()">
    <option value="" selected>Select product</option>
  </select>

  <label for="">Select variants</label>
  <select name="" id="variants" class="form-control" disabled>
    <option value="" selected>Select variants</option>
  </select>

  {{-- <label for="">Select product</label>
  <select name="product" id="" class="form-control" disabled>
    <option value="" selected>Select product</option>
  </select>

  <label for="">Select size</label>
  <select name="size" id="" class="form-control" disabled>
    <option value="" selected>Select size</option>
  </select>

  <label for="">Select quantity</label>
  <input type="number" name="quantity" id="" class="form-control" disabled> --}}

  <button class="btn btn-primary mt-3" type="submit">
    Print label
  </button>
</form>

@endsection

@section('js')
  <script>
    function source_change(){
      var source = document.getElementById('source').value;
      if(source == 'woo'){
        $.ajax({
          url: "{{route('label.getWooProducts')}}",
          type: "GET",
          success: function(data){
            console.log(data);
            var products = document.getElementById('products');
            products.innerHTML = '';
            var option = document.createElement('option');
            option.value = '';
            option.innerHTML = 'Select product';
            products.appendChild(option);
            data.data.forEach(element => {
              var option = document.createElement('option');
              option.value = element.id;
              option.innerHTML = element.name;
              products.appendChild(option);
            });
            products.disabled = false;
          }
        });
      }
    }

    function product_change(){
      const product = document.getElementById('products').value;
      $.ajax({
        url: "{{route('label.getVariantsWoo')}}",
        type: "GET",
        data: {
          product_id: product
        },
        success: function(data){
          const variants = document.getElementById('variants');
          variants.innerHTML = '';
          const length = data.data.length;
          if(length == 0){
            variants.disabled = true;
            alert('Product has no variants');
            return;
          }
          const option = document.createElement('option');
          option.value = '';
          option.innerHTML = 'Select variants';
          variants.appendChild(option);
          data.data.forEach(element => {
            const option = document.createElement('option');
            option.value = element.id;

            const size = element.attributes[0].option;
            const name = element.attributes[0].name;
            option.innerHTML = name + ' - ' + size;
            variants.appendChild(option);
          });
          variants.disabled = false;
        }
      });
    }
  </script>
@endsection
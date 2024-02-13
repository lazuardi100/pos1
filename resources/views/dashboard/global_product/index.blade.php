@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')  
<h1>Add product</h1>
@stop

@section('content')
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{session('success')}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  <form action={{route('global_product.save')}} method="post">
    @csrf
    <label class="form-label">Product Name</label>
    <input type="text" class="form-control" name="product_name" required>
    <label class="form-label">Product Description</label>
    <input type="text" class="form-control" name="product_description" required>

    <div class="form-check mt-3">
      <input class="form-check-input" type="checkbox" value="1" name="woo_save" checked>
      <label class="form-check-label" for="flexCheckDefault">
        Simpan ke Woocommerce
      </label>
    </div>

    <div class="form-check mt-3">
      <input class="form-check-input" type="checkbox" value="1" name="shopify_save" checked>
      <label class="form-check-label" for="flexCheckDefault">
        Simpan ke Shopify
      </label>
    </div>

    <button type="submit" class="btn btn-primary mt-3">
      Buat Produk
    </button>
  </form>
@endsection
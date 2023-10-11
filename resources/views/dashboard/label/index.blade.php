@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')  
<h1>Print label</h1>
@stop

@section('content')
<form action={{route('label.print')}} method="post">
  @csrf
  <label for="">Select source</label>
  <select name="source" id="source" class="form-control">
    <option value="" selected>Select source</option>
    <option value="woo">woocommerce</option>
    <option value="shopify" disabled>shopify</option>
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
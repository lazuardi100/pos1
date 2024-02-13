@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1>Transfer product Shopify to Woo</h1>
@stop

@section('content')
  <div >
    @if (session('error'))
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
      </div>
    @endif
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Product Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $product->title }}</td>
            <td>
              <a href={{ route('transfer_product.from_shopify_detail', ['id' => $product->id]) }}
                class="btn btn-primary">Transfer</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
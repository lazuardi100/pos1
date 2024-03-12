@extends('adminlte::page')

@section('title', 'Offline Products')

@section('content')
  {{-- create button --}}
  <div class="card mt-3">
    <div class="card-header">
      <a href="{{ route('offline.products.new') }}" class="btn btn-primary">Create Offline Product</a>
    </div>
  </div>
  <div class="card">
    {{-- search --}}
    <div class="card-header">
      <form action="{{ route('offline.products.index') }}" method="get">
        <label for="">Search products</label>
        <div class="input-group">
          <input type="search" name="search" class="form-control form-control" placeholder="Type your keywords here"
            value="{{ Request::get('search') }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Product Name</th>
            <th>Business Unit</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {{-- {{$i=1}} --}}
          @foreach ($products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->businessUnit->name }}</td>
              <td>{{ $product->stock }}</td>
              <td>{{ $product->price }}</td>
              <td>
                <a href="{{ route('offline.products.show', $product->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('offline.products.destroy', $product->id) }}" method="post" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
    <!-- /.card-body -->

    <div class="card-footer clearfix">
      <ul class="pagination pagination-sm m-0 float-right">
        {{-- {{$businessUnits->links()}} --}}
      </ul>
    </div>
  </div>
  <!-- /.card -->
  {{-- @include('dashboard.offline.products.create')
  @include('dashboard.offline.products.edit')
  @include('dashboard.offline.products.delete') --}}
@endsection
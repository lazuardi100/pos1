@extends('adminlte::page')

@section('title', 'Edit Product'. $product->name)

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title text-bold">Edit Product</h3>
    </div>
    <form action="{{ route('offline.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{ $product->id }}">
      <div class="card-body">
        {{-- image preview --}}
        <div class="form-group row">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <img src="{{ asset('offline_products_images/'.$product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px">
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Product Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
          </div>
        </div>
        {{-- business unit --}}
        <div class="form-group row">
          <label for="business_unit_id" class="col-sm-2 col-form-label">Business Unit</label>
          <div class="col-sm-10">
            <select name="business_unit_id" id="business_unit_id" class="form-control" required>
              <option value="">Select Business Unit</option>
              @foreach ($businessUnits as $businessUnit)
                <option value="{{ $businessUnit->id }}" {{ $product->business_unit_id == $businessUnit->id ? 'selected' : '' }}>{{ $businessUnit->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- price --}}
        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Price</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
          </div>
        </div>
        {{-- stock --}}
        <div class="form-group row">
          <label for="stock" class="col-sm-2 col-form-label">Stock</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
          </div>
        </div>
        {{-- image --}}
        <div class="form-group row">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
          </div>
        </div>
        {{-- description --}}
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
          </div>
        </div>
        {{-- sku with generate button --}}
        <div class="form-group row">
          <label for="sku" class="col-sm-2 col-form-label">SKU</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}" required>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('offline.products.index') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
@endsection
@extends('adminlte::page')

@section('title', 'Create Offline Product')

@section('content')
  <div class="card">
    <form action="{{ route('offline.products.create') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Product Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
          </div>
        </div>
        {{-- business unit --}}
        <div class="form-group row">
          <label for="business_unit_id" class="col-sm-2 col-form-label">Business Unit</label>
          <div class="col-sm-10">
            <select name="business_unit_id" id="business_unit_id" class="form-control" required>
              <option value="">Select Business Unit</option>
              @foreach ($businessUnits as $businessUnit)
                <option value="{{ $businessUnit->id }}">{{ $businessUnit->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- price --}}
        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Price</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
          </div>
        </div>
        {{-- stock --}}
        <div class="form-group row">
          <label for="stock" class="col-sm-2 col-form-label">Stock</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
          </div>
        </div>
        {{-- image --}}
        <div class="form-group row">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
          </div>
        </div>
        {{-- description --}}
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
          </div>
        </div>

        {{-- sku with generate button --}}
        <div class="form-group row">
          <label for="sku" class="col-sm-2 col-form-label">SKU</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}" required>
            <button type="button" class="btn btn-primary" id="generate-sku">Generate SKU</button>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('offline.products.index') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>

  
@endsection

@section('js')
{{-- generate sku number with 16 digits number --}}
<script>
  $(document).ready(function () {
    generateSKU();
    $('#generate-sku').click(function () {
      generateSKU();
    });
  });

  function generateSKU() {
    var sku = Math.floor(1000000000000000 + Math.random() * 9000000000000000);
    $('#sku').val(sku);
  }
</script>
@endsection
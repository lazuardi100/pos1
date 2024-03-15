@extends('adminlte::page')

@section('title', 'Edit Variant')

@section('content')
  <section class="content">
    <form action="{{ route('products.variant.update') }}" method="post"
      enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{ $data->id }}">
      <input type="hidden" name="variant_id" value="{{ $variant->id }}">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">

                <div class="card-body">
                  @if ($data == null)
                    <div class="form-group">
                      <label for="inputStatus">Type</label>
                      <select name="type" class="form-control custom-select" name="drpDown" id="drpDown" readonly>
                        <option value="1">Single product</option>
                        <option value="2">Variable product</option>
                      </select>
                    </div>
                  @endif

                  {{-- <div class="form-group">
                    <label for="inputName">Image</label>
                    <input type="file" name="image[]" multiple="multiple" id="inputName" class="form-control">
                  </div> --}}
                  <div class="form-group">
                    <label for="inputName">Variant Name</label>
                    <input type="text" name="name" id="inputName" value="{{ $variant->name }}"
                      class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="inputName">SKU</label>
                    <input type="text" name="code" id="inputName" value="{{ $variant->sku }}"
                      class="form-control">
                  </div>


                  {{--                        <div class="form-group"> --}}
                  {{--                            <label for="inputStatus">Status</label> --}}
                  {{--                            <select id="inputStatus" class="form-control custom-select"> --}}
                  {{--                                <option selected disabled>Select one</option> --}}
                  {{--                                <option>On Hold</option> --}}
                  {{--                                <option>Canceled</option> --}}
                  {{--                                <option>Success</option> --}}
                  {{--                            </select> --}}
                  {{--                        </div> --}}

                  <div class="form-group">
                    <label for="inputStatus">Barcode Symbology</label>
                    <select id="inputStatus" name="barcode" class="form-control custom-select">
                      <option value="barcode128">barcode 128</option>
                      <option value="qrcode">qrcode</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputName">price modal</label>
                    <input type="text" name="price_modal" value="{{ $variant->price }}"
                      id="inputName" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <label for="inputName">price sale</label>
                    <input type="text" name="price" value="{{ $variant->regular_price }} "
                      id="inputName" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="inputStatus">Description</label>
                    <textarea id="summernote" name="dsc" class="form-control">
                      {{ $variant->description }}
                    </textarea>
                  </div>
                </div>
              </div>



              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName">quantity</label>
                    <input type="text" name="quantity" value="{{ $variant->stock_quantity }} "
                      id="inputName" class="form-control">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href={{ route('products.index') }} class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success float-right"> Save </button>
          </div>
        </div>
    </form>
  </section>
@endsection

@extends('adminlte::page')

@section('title', 'Stock')

@section('content')
  <div class="card">
    {{-- search --}}
    <form action="{{ route('products.stock.index') }}" method="get">
      <label for="">Search product</label>
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
  <!-- /.card-header -->
  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width: 10px">#</th>
          <th>Name</th>
          <th>stock status</th>
          <th>quantity</th>
          <th>type</th>
          <th>
            Change stock
          </th>

        </tr>
      </thead>
      <tbody>
        {{-- {{$i=1}} --}}
        @foreach ($products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>
              @if ($product->stock_status == 'outofstock')
                @php
                  $class = 'badge badge-danger';
                @endphp
                @elseif($product->stock_status == 'instock')
                @php
                  $class = 'badge badge-success';
                @endphp
                @elseif($product->stock_status == 'onbackorder')
                @php
                  $class = 'badge badge-warning';
                @endphp
                @else
                @php
                  $class = 'badge badge-secondary';
                @endphp
              @endif
              <span class="{{ $class }}">{{ $product->stock_status }}</span>
            </td>
            <td>{{ $product->stock_quantity }}</td>
            <td>{{ $product->type }}</td>
            <td>
              @if ($product->type != 'variable')
                <a href="{{ route('products.stock.show', $product->id) }}" class="btn btn-primary">Edit</a>
              @else
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                  aria-expanded="false">
                  Select Variants
                </button>
                @php
                  $base = new \App\Http\Controllers\Controller();
                  $woo = $base->woocommerce();
                  $variants = $woo->get('products/' . $product->id . '/variations');
                @endphp
                <div class="dropdown-menu">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Variant</th>
                        <th>stock status</th>
                        <th>Stock</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($variants as $variant)
                        <tr>
                          <td>{{ $variant->attributes[0]->option }}</td>
                          <td>
                            @if ($variant->stock_status == 'outofstock')
                              @php
                                $class = 'badge badge-danger';
                              @endphp
                              @elseif($variant->stock_status == 'instock')
                              @php
                                $class = 'badge badge-success';
                              @endphp
                              @elseif($variant->stock_status == 'onbackorder')
                              @php
                                $class = 'badge badge-warning';
                              @endphp
                              @else
                              @php
                                $class = 'badge badge-secondary';
                              @endphp
                            @endif
                            <span class="{{ $class }}">{{ $variant->stock_status }}</span>
                          </td>
                          <td>{{ $variant->stock_quantity }}</td>
                          <td>
                            <a href="{{ route('products.stock.variant.show', [$product->id, $variant->id]) }}"
                              class="btn btn-primary">Edit</a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  {{ $products->links('vendor.pagination.bootstrap-4') }}
  </div>
@endsection
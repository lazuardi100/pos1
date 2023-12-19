@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>List Produk</h1>
@stop

@section('content')
{{-- <h1>List Produk</h1>--}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Striped Full Width Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>
                        <span class="info-box-icon"><i class="far fa-image"></i></span>
                    </th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>variant</th>
                    <th>code</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                {{-- {{$i=1}}--}}
                @foreach($products as $product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if ($product->images != [])
                            <img src="{{$product->images[0]->src}}" width="50" height="50">
                        @endif
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{($product->sku == '') ? '-' : $product->sku}}</td>
                    <td>{{($product->stock_status == 'instock') ? 'in stock' : 'Out of stock'}}</td>
                    <?php
                    $harga = (double) $product->price * (double)8500;
                    $rupiah=number_format($harga,2,',','.');
                    ?>
                    <td>Rp.{{$rupiah }}</td>
                    {{-- <td>{!! $product->price_html !!}</td>--}}
                    <td>
                        @foreach($product->categories as $category)
                        {{$category->name}},
                        @endforeach
                    </td>
                    <td>{{$product->type}}</td>
                    <td>
                        {!! DNS1D::getBarcodeHTML('dwqdqw', "C128",1.4,22) !!}

{{--                    @foreach($product->tags as $tag)--}}
{{--                        {{$tag->name}},--}}
{{--                        @endforeach--}}
{{--                    </td>--}}
                    <td>
                        <div class="btn-group">
{{--                            <a href="{{route('printLabel',[$product->type,$product->id])}}" class="btn btn-info">--}}
{{--                                <i class="fas fa-file"></i>--}}
{{--                            </a>--}}
{{--                            <button type="button" class="btn btn-info">--}}
{{--                                <i class="fas fa-image"></i>--}}
{{--                            </button>--}}
                            <a href="{{route('products.edit',$product->id)}}" type="button" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{route('products.destroys',$product->id)}}" onclick="return confirm(`Are you sure?`)">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </a>
                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    {{ $products->links('vendor.pagination.bootstrap-4') }}


    <!-- /.card-body -->
    <!-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div> -->

</div>
@stop

@section('css')

<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop

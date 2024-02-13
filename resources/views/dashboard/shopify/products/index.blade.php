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
                    <th>
                        <span class="info-box-icon"><i class="far fa-image"></i></span>
                    </th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>variant</th>
                    <th>code</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                {{-- {{$i=1}}--}}
                @foreach($products as $product)
                <tr>
                    <td><img src="{{$product->image->src}}" width="50" height="50"></td>
                    <td>{{$product->title}}</td>
                    <td>
                        @foreach($product->variants as $variant)
                            {{$variant->sku}}, 
                        @endforeach
                    </td>
                    <?php
                    $temp_prices = [];
                    foreach ($product->variants as $variant) {
                        $harga = (double) $variant->price * (double)8500;
                        $rupiah=number_format($harga,2,',','.');
                        array_push($temp_prices, $rupiah);
                    }
                    ?>
                    <td>
                        @foreach ($temp_prices as $price)
                            Rp. {{$price}}, 
                        @endforeach
                    </td>
                    <td>
                        @foreach ($product->variants as $variant)
                            {{$variant->title}},
                        @endforeach
                    </td>
                    <td>
                        {!! DNS1D::getBarcodeHTML($product->id, "C128",1.4,22) !!}
                    <td>
                        <div class="btn-group">
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
    {{ $products->links() }}


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
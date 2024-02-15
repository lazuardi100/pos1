@extends('adminlte::page')

@section('title', 'Stock')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title text-center">Product Stock</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action={{route('products.stock.update')}} method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" value="{{$product->name}}" readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Stock Status</label>
                        <select name="stock_status" id="stock_status" class="form-control">
                            <option value="instock" {{$product->stock_status == 'instock' ? 'selected' : ''}}>
                                In stock
                            </option>
                            <option value="outofstock" {{$product->stock_status == 'outofstock' ? 'selected' : ''}}>
                                Out of stock
                            </option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Stock Quantity</label>
                        <input type="number" class="form-control" value="{{$product->stock_quantity}}" name="stock_quantity">
                    </div>
                    {{-- button submit --}}
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
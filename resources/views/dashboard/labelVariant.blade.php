@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}

@stop

@section('content')

    {{-- <h1>List Produk</h1>--}}
    <div class="card">
        <div class="card-body">
            <center>
                <a href="{{route('products.clear.label')}}" class="btn btn-danger">clear</a>
            </center>

            <form action="{{route('products.labelPrint')}}" method="post">
                @csrf
                @foreach($labels as $label )
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                           <label for="inputName">Name Product</label>
                           <input type="text" name="name[]" value="{{$label->name}}"  id="inputName" class="form-control" readonly>
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label for="inputName">Unit Price</label>
                           <input type="text" name="unit_pirce[]" value="{{$label->unit_pirce}}"  id="inputName" class="form-control" readonly>
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label for="inputName">qty</label>
                           <input type="text" name="qty[]" value="{{$label->qty}}" id="inputName" class="form-control">
                       </div>
                   </div>
               </div>
                @endforeach
                <center><button type="submit" class="btn btn-success">Print</button></center>
            </form>
        </div>
    </div>
    <br><br>
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

                    <th>Name</th>

                    <th>variant</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
                {{-- {{$i=1}}--}}
{{--                @dd()--}}
                @foreach($products as $product)
                    <tr>
                        <td>{{$loop->iteration}}</td>

                        <td>{{$get->name.' - '.$product->attributes[0]->option}}</td>
                        <td>{{$product->attributes[0]->option}}</td>

                        <td>
                            <div class="btn-group">
                                <a href="{{route('products.actionLabel',[$product->id,$get->name.' - '.$product->attributes[0]->option,$product->price])}}" class="btn btn-info">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


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

@section('js')
@stop

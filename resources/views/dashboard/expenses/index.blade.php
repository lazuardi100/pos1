@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>List Expense</h1>
@stop

@section('content')
    @include('dashboard.alert')
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
                    <th>Price</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
{{--                {{$i=1}}--}}
                @foreach($data as $a)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$a->name}}</td>
                    <td><b>$</b> {{$a->price}}</td>

{{--                    <td>{!! $product->price_html !!}</td>--}}
                    <td><div class="btn-group">

                            <a href="{{route('expense.edit',$a->id)}}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{route('expense.destroys',$a->id)}}" onclick="return confirm(`Are you sure?`)">
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
{{--    {!! $products->links() !!}--}}

    <!-- /.card-body -->

    </div>
@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

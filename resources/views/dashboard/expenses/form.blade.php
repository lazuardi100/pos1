@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Category</h1>
@stop

@section('content')
    @include('dashboard.alert')

{{--    {{$edit}}--}}
    <section class="content">
            <form action="{{($edit == "yes") ? route('expense.update',$data->id) : route('expense.store') }}" method="post">
                @if($edit =="yes")
                    @method('PUT')
                @endif
                @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" name="name" id="inputName" value="{{($edit == "yes") ? $data->name : '' }}" class="form-control">
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName">Price</label>
                            <input type="text" name="price" id="inputName" value="{{($edit == "yes") ? $data->price : '' }}" class="form-control">
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success float-right"> Save </button>
            </div>
        </div>
        </form>
    </section>
@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

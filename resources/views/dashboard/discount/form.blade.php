@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>discount</h1>
@stop

@section('content')
    @include('dashboard.alert')

{{--    {{$edit}}--}}
    <section class="content">
            <form action="{{($edit == "yes") ? route('discount.update',$data->id) : route('discount.store') }}" method="post">
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
                            <label for="inputName">Discount</label>
                            <input type="text" name="discount" id="inputName" value="{{($edit == "yes") ? $data->discount : '' }}" class="form-control">
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

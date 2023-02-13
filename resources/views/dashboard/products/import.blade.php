@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Produk</h1>
    {{--    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">--}}
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">

@stop

@section('content')
    <section class="content">
        <form action="{{route('products.importAction')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Import</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card-body">


                                    <div class="form-group">
                                        <label for="inputName">File</label>
                                        {{--                            <input>--}}
                                        <input type="file" name="file" id="inputName" class="form-control">
                                    </div>

                                    </div>
                                </div>
                            </div>
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
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

@stop

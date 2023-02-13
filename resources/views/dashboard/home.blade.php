@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6" style="text-align: end;padding-right: 100px">
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">Filter
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('dashboard')}}">Today</a>
                    <a class="dropdown-item" href="{{route('dashboardFilter','yesterday')}}">Yesterday</a>
                    <a class="dropdown-item" href="{{route('dashboardFilter','last7day')}}">Last 7 day</a>
                    <a class="dropdown-item" href="{{route('dashboardFilter','last30day')}}">last 30 day</a>
                    <a class="dropdown-item" href="{{route('dashboardFilter','thisMonth')}}">this month</a>
                    <a class="dropdown-item" href="#">last month</a>
                </div>
            </div>
        </div>
    </div>
{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}

@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total sales<span>
                <span class="info-box-number">$ {{$data['total_sales']}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">net</span>
                    <span class="info-box-number"><b>$</b> {{ ($net <= 0 ) ?'0' : $net}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">

            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">invoice due</span>
                    <span class="info-box-number">13,648</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">total purhase</span>
                    <span class="info-box-number">93,139</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>88
        <!-- /.col -->
    </div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Line Chart</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

@stop

@section('js')
{{--    <script src="{{asset('uplot/uPlot.iife.min.js')}}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
    const labels = [

        @foreach($dates as $a)
            '{{$a}}',
        @endforeach
    ];

    const data = {
        labels: labels,
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [
            @foreach($totals as $total)
                {{(int)$total->sales}},
                @endforeach
            ],
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

@stop

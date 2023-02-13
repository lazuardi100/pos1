@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

{{--    <link rel="stylesheet" href="{{asset('uplot/uPlot.min.css')}}">--}}

@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Date</th>
                    <th>Name Customer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Grand total</th>
                    <th>Note</th>
                    <th>Paid</th>
                    <th>Hold ? </th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
                {{--                {{$i=1}}--}}
                @foreach($data as $a)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$a->created_at}}</td>
                        <td>{{$a->customers->name}}</td>
                        <td>
                            <?php
                            $tmp = (float)0;
                            foreach ($a->carts as $cart){
                                $tmp = $tmp + (float) $cart->subTotal;
                            }
                            ?>
                            {{$tmp}}
                        </td>
                        <td>{{$a->note_pay}}</td>
                        <td> {{$a->customers->discount}}</td>
                        <td> {{$a->note_pay}}</td>
                        <td>{{(float)$tmp - (float)$a->customers->discount}}</t>
                        <td> {{$a->hold}}</td>

                        {{--                    <td>{!! $product->price_html !!}</td>--}}
                        <td><div class="btn-group">

                                <a href="{{route('printInvoice',$a->id)}}" class="btn btn-warning">
                                    invoice
                                </a>
                                <a href="{{route('printShipping',$a->id)}}" class="btn btn-success" >
                                    shipping slip
                                </a>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
            <!-- /.info-box -->
        </div>
    </div>

@stop

@section('js')

@stop

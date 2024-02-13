<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice Print</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h1 class="fw-bold">Blotter</h1>
                <div class="w-100">
                    <h3 class="text-center">Invoice</h3>
                </div>
                <div class="d-flex justify-content-between w-100">
                    <div class="w-50">
                        <h5>
                            <span class="fw-bold">Invoice No.</span> {{$data->id}}
                        </h5>
                    </div>
                    <div class="w-50">
                        <h5 class="text-end">
                            <span class="fw-bold">Date:  </span>{{$data->created_at}}
                        </h5>
                    </div>
                </div>

                <div>
                    <h5>
                        <span class="fw-bold">Customer </span>{{$data->customers->name}}
                    </h5>
                </div>
                <div class="my-5">
                    {{-- customer phone --}}
                    <h5>
                        <span class="fw-bold">Phone </span>{{$data->customers->phone}}
                    </h5>
                </div>
            </div>
            <!-- /.col -->
        </div>

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $cart)
                        <tr>
                            <td>{{$cart->name}}</td>
                            <td>{{$cart->qty}}</td>
                            <td>{{$cart->price}}</td>
                            <td>{{$cart->subTotal}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        {{-- bold separator line --}}
        <div class="row">
            <div class="col-12">
                <hr class="border border-5 border-dark">
            </div>
        </div>
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">

{{--                <p class="lead">Amount Due 2/22/2014</p>--}}
                <p></p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td style="width:50%">Cash:</td>
                            <td>${{$data->amount_pay}}</td>
                            {{-- created at with format dd/mm/yyyy --}}
                            <td>
                                {{$data->created_at->format('d/m/Y')}}
                            </td>
                        </tr>
                        <tr>
                            <th>Total Paid</th>
                            <td>${{$data->amount_pay}}</td>
                            <td></td>
                        </tr>

                    </table>
                </div>

            </div>
            <!-- /.col -->
            <div class="col-6">
{{--                <p class="lead">Amount Due 2/22/2014</p>--}}
                <p></p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td class="text-end">${{$total}}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td class="text-end">${{$total}}</td>
                        </tr>
                    </table>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // window.addEventListener("load", window.print());
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice Print</title>

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
                <h2 class="page-header">
                    <i class="fas fa-globe"></i> Invoice
                    <small class="float-right">Date: {{$data->created_at}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Admin.</strong><br>
                    <b>Customer : </b>{{$data->customers->name}}<br>
                </address>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $cart)
                        <tr>
                            <td>{{$cart->qty}}</td>
                            <td>{{$cart->name}}</td>
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

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">

{{--                <p class="lead">Amount Due 2/22/2014</p>--}}
<p></p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Cash:</th>
                            <td>${{$data->amount_pay}}</td>
                        </tr>
                        <tr>
                            <th>Cash Paid</th>
                            <td>${{$data->amount_pay}}</td>
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
                            <td>${{$total}}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>${{$total}}</td>
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
<script>
    window.addEventListener("load", window.print());
</script>
</body>
</html>

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
    <style>
        table, th, td {
            border: 3px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<div class="wrapper" style="padding: 100px">

    <center>
        <table style="width: 100%">
            <tr >
                <th><center><a style="font-size: 100px;"> P </a></center></th>
                <th width="80%"><a style="float: right;">{!! DNS2D::getBarcodeHTML(substr(str_shuffle("0123456789"), 0, 13), 'QRCODE') !!}</a></th>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <h1>PRIORITY MAIL</h1>
                    </center>
                </td>
            </tr>
            <tr style="height: 300px">
                <td colspan="2">
                    Shiping to : {{$shipping}}
                </td>
            </tr>
            <tr style="height: 100px">
                <td colspan="2">
                    <?php
                    $random = substr(str_shuffle("0123456789"), 0, 13);
                    ?>
                    <a>
                        <center>
                            {!! DNS1D::getBarcodeHTML($random, "C128",1.4,22) !!}
                            {{$random}}
                        </center>
                    </a>
                </td>
            </tr>   <tr>
                <td colspan="2">{{$cs->customer_track}}</td>
            </tr>
        </table>
    </center>
    <!-- Main content -->

    <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
    // window.addEventListener("load", window.print());
</script>
</body>
</html>

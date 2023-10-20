<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice Print</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <style>
        table, th, td {
            border: 3px solid black;
            border-collapse: collapse;
        }

        .print_section{
            /* panjang 100cm tinggi 150cm */
            width: 100mm;
            height: 150mm;
        }
    </style>
</head>
<body>
<div class="wrapper print_section">

    <center>
        <table style="width: 100%">
            <tr >
                <th><center><a style="font-size: 50px;"> P </a></center></th>
                <th width="80%">
                    <div>
                        <p></p>
                        {{-- <a style="float: right;">{!! DNS2D::getBarcodeHTML(substr(str_shuffle("0123456789"), 0, 13), 'QRCODE') !!}</a> --}}
                        <div style="float: right;" id="qrcode">

                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <h3>PRIORITY MAIL</h3>
                    </center>
                </td>
            </tr>
            <tr style="height: 250px">
                <td colspan="2">
                    <div class="row ml-3">
                        <div class="col-6">
                            <p class="lh-sm fs-5">
                                Don Bimam 
                                <br> 
                                221 Baker Street
                                <br>
                                Santa Carla, CA 12345
                            </p>
                            
                        </div>
                    </div>
                    <div class="row ml-3">
                        <div class="col-4">
                            <p class="fs-5">Shiping to :</p>
                        </div>
                        <div class="col-6">
                            <p class="lh-sm fs-5">
                                Holly Golightly
                                <br>
                                1428 Elm Street
                                <br>
                                San Junipero, CA 67809
                            </p>
                            {{-- {{$shipping}} --}}
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="height: 70px">
                <td colspan="2">
                    <?php
                    $random = substr(str_shuffle("0123456789"), 0, 13);
                    ?>
                    <a>
                        <center>
                            {{-- {!! DNS1D::getBarcodeHTML($random, "C128",10,450) !!} --}}
                            <canvas id="barcode" value={{$random}}></canvas>
                            {{-- <h1>
                                {{$random}}
                            </h1> --}}
                        </center>
                    </a>
                </td>
            </tr>   <tr>
                <td colspan="2">
                    {{-- {{$cs->customer_track}} --}}
                    <center>
                        <h5>
                            Tracking #: DX-PV54
                        </h5>
                    </center>
                </td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src={{url('vendor/qrcodejs/qrcode.min.js')}}></script>
<script>
    const qrcode = new QRCode(document.getElementById('qrcode'), {
        text: '{{$data->id}}',
        width: 64,
        height: 64,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
</script>

<script src={{url('vendor/jsbarcode/JsBarcode.all.min.js')}}></script>

<script>
    JsBarcode("#barcode", "{{$random}}", {
        format: "CODE128",
        lineColor: "#000",
        width: 4,
        height: 60,
        displayValue: true
    });
</script>

</body>
</html>

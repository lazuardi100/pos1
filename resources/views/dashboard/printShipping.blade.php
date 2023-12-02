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
        @media print {
            html,body {
                width: 70mm;
                height: 105mm;
            }
        /* etc */
        }
        @page {
            size: 70mm 105mm;
            margin: 3px;
        }
        table, th, td {
            border: 3px solid black;
            border-collapse: collapse;
        }
        body{
            margin: 0;
        }

        .print_section{
            /* panjang 100cm tinggi 150cm */
            width: 100mm;
            min-height: 150mm;
            /* border: 2px solid red; */
        }
    </style>
</head>
<body>
<div class="wrapper print_section">
    <table style="width: 100%; min-height:150mm">
        <tr >
            <th><center><a style="font-size: 50px;"> P </a></center></th>
            <th width="80%">
                <div class="row">
                    <div class="col-8">
                        {{-- <p class="text-center" style="font-size: 40px;">Blotter</p> --}}
                    </div>
                    {{-- <a style="float: right;">{!! DNS2D::getBarcodeHTML(substr(str_shuffle("0123456789"), 0, 13), 'QRCODE') !!}</a> --}}
                    <div class="col-4">
                        <div style="float: right;" id="qrcode"></div>
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
                        <p class="lh-sm fs-6">
                            Blotter International
                            <br> 
                            JL TEUKU UMAR, PEKANBARU 28112 
                            <br>
                            +62 822-8890-7898
                        </p>
                        
                    </div>
                </div>
                <div class="row ml-3">
                    <div class="col-4">
                        <p class="fs-5">Shiping to :</p>
                    </div>
                    <div class="col-6">
                        <p class="lh-sm fs-5">
                            {{ $customer_name }}
                            <br>
                            {{ $shipping}}
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
        </tr>
        <tr>
            <td colspan="2">
                {{-- {{$cs->customer_track}} --}}
                <center>
                    <h5>
                        www.blotterism.com
                    </h5>
                </center>
            </td>
        </tr>
    </table>
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
        text: 'www.blotterism.com',
        width: 80,
        height: 80,
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
        width: 3,
        height: 60,
        displayValue: true
    });
</script>

</body>
</html>

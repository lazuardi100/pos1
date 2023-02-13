<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <style>
    body {
        width: 4cm;
       
        }
    .label{
       
        width: 4cm; 
        height: 4cm; 
      
        margin-bottom: 3mm; 
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        font-size: 13px;

      
        padding: 3mm;
        text-align: left;
    

        outline: 1px dotted; 
        }
 
    .barcode{
      text-align: left;
    }
    .size{
      text-align: right;
      vertical-align: top;
    }
    .price{
      text-align: right;
    }
    .wrapper {
     display: grid;
     grid-template-columns: 70% 30%;
     
    }
  </style>

</head>

<body>
{{--@dd($tmp);--}}

@for($i=0;$i<$count;$i++)
    <?php
    //        dd();
    $random = substr(str_shuffle("0123456789344"), 0, 13);
    $belakang = explode(" - ",$tmpData[$i]);

    $ukuran = '';
    $tmp = '';
    if (count($belakang) == 2){
        $s = strtolower($belakang[1]);
        $ukuran = $belakang[1];
        if ($s == 's'){
            $tmp = '1';
        }elseif ($s == 'm'){
            $tmp = '2';
        }elseif ($s == 'l'){
            $tmp = '3';
        }elseif ($s == 'xl'){
            $tmp = '4';
        }elseif ($s == 'xxl'){
            $tmp = '5';
        }else {
            $tmp = '0';
        }
    }else{
        $tmp = '0';
    }
    $gabung  = $random.'-'.$tmp;
    
    
    $text = $tmpData[$i];
    
    $num_char = 8;
    $cut_text = substr($text, 0, $num_char);
    
    if ($text[$num_char - 1] != ' ') {
    	$new_pos = strrpos($cut_text, ' ');
    	
    	$cut_text = substr($text, 0, $new_pos);
    }
    $sambungan = explode($cut_text, $text); 
    // echo $cut_text.'<br>'.$sambungan['1'];
    
    // return;
    ?>
    
    <div class="label">
        <div class="wrapper">
            <div class="barcode">
                {!! DNS1D::getBarcodeHTML($gabung, "C128",0.9,30) !!}
                {{--                <img src="https://scontent-sin6-4.xx.fbcdn.net/v/t39.30808-6/309359666_5458694490843021_3496997913162019013_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=730e14&_nc_ohc=7AoKx4PLJT8AX-XeJED&_nc_ht=scontent-sin6-4.xx&oh=00_AT8XBtrbeEFFmhQNQpLPz8o0rYPJpSRr-YP_ZvxVrZXnOg&oe=6336E458" height="40cm" width="120cm">--}}
                <br>
                <a style='font-size:11px'>{{$gabung}}</a>
            </div>
            <!--<div class="size">-->
            <!--    <br>  {{$ukuran}}-->
            <!--</div>-->
        </div>
        <p style='font-size:8px'>{!! $cut_text.'<br>'.$sambungan['1'] !!}</p>
                <!--<p>{{$tmpData[$i]}}</p>-->

        <div class="price">
            <?php
            $harga = 8500 * ($tmpas[$i]['qty'] * $tmpas[$i]['unit_pirce']);
            $rupiah=number_format($harga,2,',','.');
            ?>
            IDR {{$rupiah}}
        </div>
        <br>
    </div>

@endfor
<script>
    // window.addEventListener("load", window.print());
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>
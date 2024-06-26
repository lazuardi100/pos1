<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <style>

    @media print {
        @page {
            /* size with width 4cm and height same as content */
            size: 2.85cm 2.85cm;
            margin: 3px;
        }

        .print-content {
            width: 100%; /* Set width to 100% */
            height: 0; /* Set height to 0 */
            padding-bottom: calc(100% / 1); /* Aspect ratio of A4 paper (ISO 216) */
            position: relative; /* Establish relative positioning */
        }

        .print-content > * {
                /* Position elements relatively */
            position: relative;
            /* Ensure elements don't exceed container */
            max-width: 100%;
            max-height: 100%;
            /* Add padding to create space between elements */
            padding: 5px;
            /* Add box-sizing for proper calculation of width and height */
            box-sizing: border-box;
        }
    }
        
    .label{
       
        width: 4cm; 
        height: 4cm; 
      
        margin-bottom: 3mm; 
        margin-right: 3mm;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        font-size: 13px;

      
        padding: 3mm;
        text-align: left;
    

        outline: 1px dotted; 
        }
 
    /* set horizontaly inline */
    .barcode{
        text-align: left;
    }
    .size-div{
        text-align: right;
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

<style>
    /* horizontal */
    .label-container {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        padding: 3px;
        width: 100%;
    }

    .label-list {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        background-color: blue;
        margin: 4cm;
        padding: 3px;
    }

    .canvas-barcode {
        width: 100%;
    }
</style>
</head>

<body>

@for($i=0;$i<$count;$i++)
    <?php
    $random = $tmpas[$i]['product_id'];
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
    try {
        $sambungan = explode($cut_text, $text); 
    } catch (\Throwable $th) {
        $temp_text = explode(' ', $text);
        $prefix = $temp_text[0];
        $cut_text = $prefix;
        $text = str_replace($prefix, '', $text);

        $sambungan = ["", $text];
    }
    // echo $cut_text.'<br>'.$sambungan['1'];
    
    // return;
    ?>
    
    <div class="label print-content">
        <div class="wrapper">
            <div class="barcode">
                <canvas id={{$gabung}} class="canvas-barcode"></canvas>
                
                {{-- {!! DNS1D::getBarcodeHTML($gabung, "C128",0.9,30) !!} --}}
                {{--                <img src="https://scontent-sin6-4.xx.fbcdn.net/v/t39.30808-6/309359666_5458694490843021_3496997913162019013_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=730e14&_nc_ohc=7AoKx4PLJT8AX-XeJED&_nc_ht=scontent-sin6-4.xx&oh=00_AT8XBtrbeEFFmhQNQpLPz8o0rYPJpSRr-YP_ZvxVrZXnOg&oe=6336E458" height="40cm" width="120cm">--}}
                <br>
                <a style='font-size:11px'>{{$gabung}}</a>
            </div>
            <div class="size-div">
                <p>{{$ukuran}}</p>
            </div>

            <!--<div class="size">-->
            <!--    <br>  {{$ukuran}}-->
            <!--</div>-->
        </div>
        <p style='font-size:8px' class="mb-0 truncate-text">{!! $cut_text.'<br>'.$sambungan['1'] !!}</p>

        <div class="price">
            <?php
                $harga = ($tmpas[$i]['unit_pirce']);
                $rupiah=number_format($harga,2,',','.');
                if ($harga > 1000){
                    $currency = "IDR";
                }else{
                    $currency = "USD";
                }
            ?>
            {{$currency." ".$rupiah}}
        </div>
        <br>
    </div>

@endfor

<script>
    // window.addEventListener("load", window.print());
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<script src={{url('vendor/jsbarcode/JsBarcode.all.min.js')}}></script>

<script>
    const canvas = document.querySelectorAll('.canvas-barcode');
    canvas.forEach((item) => {
        JsBarcode(item, item.id, {
        format: "CODE128",
        lineColor: "#000",
        width: 1,
        height: 40,
        displayValue: false,
        margin: 0
        });
    });

</script>

<script>
    function truncateTextAfterTwoLines(element) {
        const lineHeight = parseInt(window.getComputedStyle(element).lineHeight); // Get line height
        const maxHeight = lineHeight * 2; // Calculate max height for two lines
        if (element.offsetHeight > maxHeight) { // Check if content exceeds two lines
            const text = element.textContent.trim(); // Get text content
            const truncatedText = text.substring(0, Math.floor((element.offsetWidth / lineHeight) * 2)); // Truncate text
            element.textContent = truncatedText.trim() + '...'; // Add ellipsis
        }
    }

    // Call the function on window load
    window.onload = function() {
        const elements = document.getElementsByClassName('truncate-text');
        for (let i = 0; i < elements.length; i++) {
            truncateTextAfterTwoLines(elements[i]);
        }
    };
</script>
</body>

</html>
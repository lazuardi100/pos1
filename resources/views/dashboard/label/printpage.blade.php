<html>
  {{-- 
    ukuran label barcode: 40x40
    gap/jarak antar label: 3mm
    layout:
    ——————————-
    {BARCODE}   {Size}
    {KODE BARCODE}

    {Brand Name}
    {Product Name}
    {price}
  --}}

  <head>
    <style>
      @page {
        /* size: 47mm 47mm; */
        margin: 0;
      }
      @media print {
        /* .label {
          page-break-after: always;
        } */
      }
      body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
      }
      .label {
        width: 40mm;
        height: 40mm;
        padding: 0;
        margin: 3mm;
        border: 1px solid black;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }
      .label .barcode {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 0 5px;
      }
      .barcode-number {
        font-size: 10px;
        padding: 0 5px;
      }
      .label .barcode .size {
        font-size: 10px;
      }
      .label .brand-name {
        font-size: 10px;
        padding: 0 5px;
      }
      .label .product-name {
        font-size: 10px;
        padding: 0 5px;
      }
      .label .price {
        font-size: 10px;
        padding: 0 5px;
      }
    </style>

    <body>
      @php
        $counted_label = 0;
      @endphp
      @foreach ($datas as $label)
        <div class="label">
          <div class="barcode">
            <div class="barcode-number">
              <canvas id={{$label->id}} class="canvas-barcode">

              </canvas>
            </div>
            <div class="size">
              {{$label->size}}
            </div>
          </div>
          <div class="barcode-number">
            {{$label->id}}
          </div>
          <div class="brand-name">
            Blotter
          </div>
          <div class="product-name">
            {{$label->name}}
          </div>
          <div class="price">
            Rp. {{$label->price}}
          </div>
        </div>
        @php
          $counted_label++;
        @endphp
        @if ($counted_label % 6 == 0)
          <div style="page-break-after: always;"></div>
          {{-- add space 3mm --}}
          <div style="height: 1mm;"></div>
        @endif
      @endforeach
    </body>

    <script src={{url('vendor/jsbarcode/JsBarcode.all.min.js')}}></script>

    <script>
      const canvas = document.querySelectorAll('.canvas-barcode');
      canvas.forEach((item) => {
        JsBarcode(item, item.id, {
          format: "CODE128",
          lineColor: "#000",
          width: 1.4,
          height: 25,
          displayValue: false,
          margin: 0
        });
      });
      
    </script>
</html>
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
        size: 40mm 40mm;
        margin: 0;
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
      @foreach ($datas as $label)
        <div class="label">
          <div class="barcode">
            <div class="barcode-number">
              {!! DNS1D::getBarcodeHTML($label->id, "C128",1.4,22) !!}
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
      @endforeach
    </body>
</html>
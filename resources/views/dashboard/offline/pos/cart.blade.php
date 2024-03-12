    <div class="form-group">
      <br>
      <div class="input-group ">
        <label for=""></label>

        <select class="customer_select form-control" onchange="changeCustomer()" name="customer_id" id="customer_id">
          <option>Pilih Customer</option>
          @foreach ($customers as $customer)
            @if (count($carts) > 0)
              @if ($customer->id == $carts[0]->customer_id)
                <option value="{{ $customer->id }}" selected>{{ $customer->name }} -
                  {{ $customer->id }}</option>
              @else
                <option value="{{ $customer->id }}">{{ $customer->name }} -
                  {{ $customer->id }}</option>
              @endif
            @else
              <option value="{{ $customer->id }}">{{ $customer->name }} -
                {{ $customer->id }}</option>
            @endif
          @endforeach
        </select>

        <div class="input-group-append">
          <span class="input-group-text" data-toggle="modal" data-target="#modal-customer"><i class="fas fa-plus"
              style="color: green"></i></span>
        </div>
      </div>
      <div class="form-group mt-3">
      </div>
    </div>

    <table style="width: 100%;font-weight: bold">

      <tr style="background-color: #b4f2b4;">
        <td>Product</td>
        <td>Price</td>
        <td>Qty</td>
        <td>Sub total </td>
        <td>act</td>
      </tr>

      <div>
        @foreach ($carts as $cart)
          <tr>
            <td> {{ $cart->product_name }}</td>
            <td>
              <div class="price">{{ $cart->price }}</div>
            </td>
            <td>
              <input type="text" value="{{ $cart->quantity }}" id="qty"
                onchange="change({{ $cart->id }},$(this).val())" name="qty" style="width: 30px">
            </td>
            <td>{{ $cart->subtotal }}</td>
            <td>
              <a href={{route('offline.cart.destroy', $cart->id)}}>
                <i class="fas fa-trash-alt" style="color: red"></i>
              </a>
            </td>

          </tr>
        @endforeach

      </div>

    </table>

    {{-- error --}}
    <div style="position: absolute;bottom: 0px;">
      <table style="width: 100%;">
        <tr>
          <td>Total Item : {{ $count }}</td>
          <td>Total <a id="totalS"> {{ $total }}</a></td>
        </tr>
        <tr>
          <td>discount : <a id="discountT"> 0</a></td>
          <td>tax : 0</td>
        </tr>
        <tr>
          <td>total payable : <a id="totalPay"> {{ $total }}</a></td>
        </tr>
      </table>

      <a onclick="hold()" class="btn btn-danger">Hold</a>
      <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-payment">Payment</button>

    </div>


    <div class="modal fade" id="modal-customer">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Create Customer</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('createCustomer') }}" method="post">
              @csrf

              <div class="form-group mt-3">
                <label>Name </label>
                <input type="input" name="customer_name" class="form-control" id="exampleInputEmail1" required>

              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mt-3">
                    <label>Email </label>
                    <input type="email" name="customer_email" class="form-control" id="exampleInputEmail1" required>

                  </div>
                  <div class="form-group mt-3">
                    <label>Address </label>
                    <input type="input" name="customer_address" class="form-control" id="exampleInputEmail1" required>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mt-3">
                    <label>Phone </label>
                    <input type="input" name="customer_phone" class="form-control" id="exampleInputEmail1">

                  </div>
                  <div class="form-group mt-3">
                    <label>Tracking Number </label>
                    <input type="input" name="customer_track" class="form-control" id="exampleInputEmail1">

                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-payment">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table style="width: 100%;">
              <tr>
                <td>Total Item : {{ $count }}</td>
                <td>Total payable<a id="totalS"> {{ $total }}</a></td>
              </tr>
              <tr>
                <td>total paying : 0</td>
                <td>balance : <a id="txt_amount"></a></td>
              </tr>
            </table>

            <div class="form-group mt-3">
              <labe>Note </labe>
              <input type="input" name="note_pay" class="form-control" id="note_pay">

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mt-3">
                  <labe>Amount </labe>
                  <input type="input" name="amount_pay" value="0" class="form-control" id="amount_pay">

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mt-3">
                  <labe>Paying by </labe>
                  <select class="form-control " name="payingby">
                    <option value="cash">cash</option>

                  </select>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="payment()">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script>
      const as = document.querySelector('.price');

      // alert(as.innerText);

      qty = document.getElementById("qty").value;
      price = as.innerText;
      total = price * qty;

      // alert(id);

      document.getElementById("subPrice").innerHTML = total.toFixed(2);

      function discount(val) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
          /* the route pointing to the post function */
          url: '/getDiscount',
          type: 'POST',
          /* send the csrf-token and the input to the controller */
          data: {
            _token: CSRF_TOKEN,
            customer_id: val,
            // subTotal : total.toFixed(2)
          },
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function(data) {
            // $(".writeinfo").append(data.msg);
            // alert()
            var ass = '{{ $total }}';
            // console.log(parseInt(ass));
            totalss = parseFloat(ass) - parseFloat(data['discount']);
            console.log(totalss);
            document.getElementById("discountT").innerHTML = data['discount'];
            document.getElementById("totalPay").innerHTML = String(totalss);


          }
        });
      }

      function changeCustomer() {
        customer_id = document.getElementById("customer_id").value;
        // alert();

        $.ajax({
          /* the route pointing to the post function */
          url: '{{route('offline.cart.update_customer')}}',
          type: 'GET',
          /* send the csrf-token and the input to the controller */
          data: {
            customer_id: customer_id,
            // subTotal : total.toFixed(2)
          },
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function(data) {
            // $(".writeinfo").append(data.msg);
            // alert()
            console.log(data)
            // reload
            location.reload();
          }
        })
      }

      function payment() {

        const note_pay = document.getElementById("note_pay").value;
        const amount_pay = document.getElementById("amount_pay").value;

        $.ajax({
          /* the route pointing to the post function */
          url: '{{route('offline.cart.create_order')}}',
          type: 'GET',
          /* send the csrf-token and the input to the controller */
          data: {
            note_pay: note_pay,
            amount_pay: amount_pay,
          },
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function(data) {
            // $(".writeinfo").append(data.msg);
            alert(data.message)
            location.reload();

          },
          error: function(data) {
            alert(data);
          }
        });
      }

      function change(id, val) {
        const as = document.querySelector('.price');

        price = as.innerText;
        total = price * val;

        console.log(id, val);
        $.ajax({
          /* the route pointing to the post function */
          url: '{{route('offline.cart.update_qty')}}',
          type: 'GET',
          /* send the csrf-token and the input to the controller */
          data: {
            qty: val,
            id: id,
            // subTotal : total.toFixed(2)
          },
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function(data) {
            // $(".writeinfo").append(data.msg);
            // alert()
            console.log(data)
            // reload
            location.reload();
          }
        });
      }
    </script>

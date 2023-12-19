
    <div class="form-group">
        <center>
        <!--<label for="">Hold</label>-->
        <!--</center>-->
        <!--<div class="input-group mt-3">-->

        <!--    <select class="form-control" onchange="changeCustomer($(this).val())">-->
        <!--        <option >Pilih Customer</option>-->
        <!--        @foreach($customers as $customer)-->
        <!--            <option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>-->
        <!--        @endforeach-->
        <!--    </select>-->
        <!--</div>-->
        <br>
        <div class="input-group ">
            <label for=""></label>

            <select class="form-control" onchange="discount($(this).val())" name="customer_id" id="customer_id">
                <option >Pilih Customer</option>
            @foreach($customers as $customer)
                    <option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}} - {{$customer->id}}</option>
                @endforeach
            </select>

            <div class="input-group-append">
                <span class="input-group-text" data-toggle="modal" data-target="#modal-customer" ><i class="fas fa-plus" style="color: green"></i></span>
            </div>
        </div>
        <div class="form-group mt-3">
            <input type="input" class="form-control" id="reference_note" placeholder="Reference note">
        </div>
    {{--            <div class="form-group">--}}
    {{--                <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Search">--}}
    {{--            </div>--}}
    <!-- /.input group -->
    </div>

    <table style="width: 100%;font-weight: bold">

        <tr style="background-color: #b4f2b4;">
            <td>Product</td>
            <td>Price</td>
            <td>Qty</td>
            <td>Sub total </td>
            <td>act</td>
        </tr>


        @foreach($carts as $cart)

            <tr>

                <td> {{$cart->name}}</td>
                <td><div class="price">{{$cart->price}}</div></td>
                <td><input type="text" value="{{$cart->qty}}" id="qty" onchange="change({{$cart->id,}},$(this).val())" name="qty" style="width: 30px"></td>
                <td><a id="subPrice">{{$cart->subTotal}}</a></td>
                <td>
                    <a href="{{route('delete.cart',$cart->id)}}">
                        <i class="fas fa-trash-alt" style="color: red"></i>
                    </a>
                </td>

            </tr>

        @endforeach

    </table>

    <div style="position: absolute;bottom: 0px;">
        <table style="width: 100%;">
            <tr>
                <td>Total Item : {{$count}}</td>
                <td>Total <a id="totalS"> {{$total}}</a></td>
            </tr>
            <tr>
                <td>discount : <a id="discountT"> 0</a></td>
                <td>tax : 0</td>
            </tr>
            <tr>
                <td>total payable : <a id="totalPay"> {{$total}}</a></td>
            </tr>
        </table>

        <a onclick="hold()" class="btn btn-danger">Hold</a>
{{--        <a href="h" class="btn btn-warning">Invoice</a>--}}
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
                <form action="{{route('createCustomer')}}" method="post">
                    @csrf

                    <div class="form-group mt-3">
                        <labe>Name </labe>
                        <input type="input" name="customer_name" class="form-control" id="exampleInputEmail1" required>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <labe>Email </labe>
                                <input type="email" name="customer_email" class="form-control" id="exampleInputEmail1" required>

                            </div>
                            <div class="form-group mt-3">
                                <labe>Address </labe>
                                <input type="input" name="customer_address" class="form-control" id="exampleInputEmail1" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <labe>Phone </labe>
                                <input type="input" name="customer_phone" class="form-control" id="exampleInputEmail1" >

                            </div>
                            <div class="form-group mt-3">
                                <labe>Tracking Number </labe>
                                <input type="input" name="customer_track" class="form-control" id="exampleInputEmail1" >

                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <labe>Customer Discount % </labe>
                        <select class="form-control " name="customer_discount">
                            <option value="{{null}}">Select</option>
                            @foreach($discount as $dscont)
                            <option value="{{$dscont->id}}">{{$dscont->name}}</option>
                            @endforeach
                        </select>
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
                        <td>Total Item : {{$count}}</td>
                        <td>Total payable<a id="totalS"> {{$total}}</a></td>
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
                            <input type="input" name="amount_pay" value="0" class="form-control" onchange="actionAmount($(this).val())" id="amount_pay">

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
                <div class="form-group mt-3">
                    <labe>Payment Note </labe>
                    <input type="input" name="payment_note" class="form-control" id="payment_note">

                </div>

                <button type="submit" class="btn btn-primary" onclick="payment()">Save changes</button>
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

    function discount(val){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            /* the route pointing to the post function */
            url: '/getDiscount',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                customer_id:val,
                // subTotal : total.toFixed(2)
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // $(".writeinfo").append(data.msg);
                // alert()
                var ass = '{{$total}}';
                // console.log(parseInt(ass));
                totalss = parseFloat(ass) - parseFloat(data['discount']);
                console.log(totalss);
                document.getElementById("discountT").innerHTML = data['discount'];
                document.getElementById("totalPay").innerHTML = String(totalss);


            }
        });
    }

    function changeCustomer (val){
        // customer_id = document.getElementById("customer_id").value;
        // alert();


        window.location.replace("{{url('hold')}}/"+val);

    }

    function hold(){
        customer_id = document.getElementById("customer_id").value;
        // alert(customer_id);
        //
        // return;
        reference_note = document.getElementById("reference_note").value;
        payment_note = document.getElementById("reference_note").payment_note;
        amount = document.getElementById("reference_note").amount;

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            /* the route pointing to the post function */
            url: '/hold',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                customer_id:customer_id,
                reference_note:reference_note,
                payment_note:payment_note,
                amount:amount,
                // subTotal : total.toFixed(2)
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // $(".writeinfo").append(data.msg);
                // alert()
                console.log(data);
                console.log('success');
                // redirect
                window.location.replace("{{url('pos')}}");
            },
            error: function (data) {
                console.log(data);
                alert('Pilih Customer');
            }
        });

    }

    function payment(){

        customer_id = document.getElementById("customer_id").value;
        note_pay = document.getElementById("reference_note").value;
        amount_pay = document.getElementById("amount_pay").value;

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: '/createOrder',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                customer_id:customer_id,
                note_pay:note_pay,
                amount_pay:amount_pay,
                // subTotal : total.toFixed(2)
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // $(".writeinfo").append(data.msg);
                // alert()
                console.log(data);
                console.log('success');
                location.reload();

            },
            error: function (data) {
                console.log(data);
                alert('Pilih Customer');
            }
        });
    }


    function actionAmount(val){
        // alert(val)
    }
    function change(id,val){

        // alert(val);
        // return;
        const as = document.querySelector('.price');

        // alert(as.innerText);

        price = as.innerText;
        total = price * val;

        // alert(id);

        // document.getElementById("subPrice").innerHTML = total.toFixed(2);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            /* the route pointing to the post function */
            url: '/updateQty',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                qty:val,
                id:id,
                // subTotal : total.toFixed(2)
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // $(".writeinfo").append(data.msg);
                // alert()
                console.log(data)

            }
        });

        x()

    }

    var x = function total (){

        $.ajax({
            /* the route pointing to the post function */
            url: '/totalPrice',
            type: 'GET',
            /* send the csrf-token and the input to the controller */
            data: {

            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // $(".writeinfo").append(data.msg);
                // alert()
                console.log(data['total'])
                // document.getElementById("totalS").innerHTML = data['total'];
                location.reload();

            }
        });
    }


</script>


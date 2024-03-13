@extends('adminlte::page')

@section('title', 'Detail Transaction')

@section('content')
  <div class="card mt-3">
    <div class="card-header">
      <h1>Detail Transaction</h1>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="transaction_date" class="col-sm-4 col-form-label">Transaction Date</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="transaction_date" value="{{ $transaction->created_at }}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="customer_name" class="col-sm-4 col-form-label">Customer Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="customer_name" value="{{ $transaction->offline_customer->name }}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="amount_pay" class="col-sm-4 col-form-label">Amount Pay</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="amount_pay" value="{{ $transaction->amount_pay }}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="total" class="col-sm-4 col-form-label">Total</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="total" value="{{ $total }}" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card mt-3">
    <div class="card-header">
      <h1>Detail Cart</h1>
    </div>
  </div>
  <div class="card">
    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($carts as $cart)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $cart->product_name }}</td>
              <td>{{ $cart->price }}</td>
              <td>{{ $cart->quantity }}</td>
              <td>{{ $cart->price * $cart->quantity }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="4" class="text-right">Total</td>
            <td>{{ $total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <a href="{{ route('offline.transaction.index') }}" class="btn btn-primary my-3">Back</a>
@endsection
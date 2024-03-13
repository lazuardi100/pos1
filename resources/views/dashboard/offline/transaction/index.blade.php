@extends('adminlte::page')

@section('title', 'Offline Transaction')

@section('content')
  {{-- create button --}}
  <div class="card mt-3">
    <div class="card-header">
      <h1>Offline Transaction</h1>
    </div>
  </div>
  <div class="card">
    {{-- search --}}

    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Transaction Date</th>
            <th>Customer Name</th>
            <th>Amount Pay</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {{-- {{$i=1}} --}}
          @foreach ($data as $transaction)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $transaction->created_at }}</td>
              <td>{{ $transaction->offline_customer->name }}</td>
              <td>{{ $transaction->amount_pay }}</td>
              <td>
                @php
                  $total = 0;
                  $offline_cart = \App\Models\OfflineCart::where('transaction_id', $transaction->id)->get();

                  foreach ($offline_cart as $cart) {
                    $total += $cart->price * $cart->quantity;
                  }
                  echo $total;
                @endphp
              </td>
              <td>
                <a href="{{ route('offline.transaction.show', $transaction->id) }}" class="btn btn-primary">Detail</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="d-flex justify-content-center">
        {{ $data->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
@endsection
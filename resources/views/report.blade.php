@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="{{ route('order') }}" class="btn btn-sm btn-primary">New Order</a>
          </div>
        </div>
      </div>

      <h2>Order</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Order No</th>
          <th scope="col">Products</th>
              <th scope="col">Synced</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>{{ $order->date_ordered->format('d/m/y h:i') }}</td>
              <td>{{ $order->order_no }}</td>
            <td>
              @foreach($order->lines as $line)
                {{ $line->product_code }}, Qty : {{ $line->quantity }}<br/>
              @endforeach
            </td>
              <td>{{ $order->c_order_no }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $orders->links() }}
      </div>
@endsection
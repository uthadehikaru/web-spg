@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
        </div>
      </div>

      <h2>Order</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product</th>
              <th scope="col">Quantity</th>
              <th scope="col">Created By</th>
              <th scope="col">Synced</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>{{ $order->created_at->format('d/m/y h:i') }}</td>
              <td>{{ $order->product_code }}</td>
              <td>{{ $order->quantity }}</td>
              <td>{{ $order->user->name }}</td>
              <td>{{ $order->c_orderline_id }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection
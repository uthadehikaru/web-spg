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

      @if(session('message'))
      <div class="alert alert-success" role="alert">
        {{ session('message') }}
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
      </div>
      @endif

      <h2>Order</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Action</th>
              <th scope="col">Date</th>
              <th scope="col">Order</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>
                @if($order->c_order_id)
                  {{ $order->c_order_no }}
                @else
                  <a href="{{ route('order.edit', $order->order_no) }}" class="btn btn-warning btn-sm mr-2"><span data-feather="edit"></span></a>
                  <a href="{{ route('sync.delete', $order->order_no) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')"><span data-feather="trash"></span></a>
                @endif
              </td>
              <td>{{ $order->date_ordered->format('d/m/y') }}</td>
              <td>
                #{{ $order->order_no }}<br/>
                {{ $order->customer_name}}<br/>
                {{ $order->location_name}}<br/>

              </td>
              <td>{{ $order->total }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $orders->links() }}
      </div>
@endsection
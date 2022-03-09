@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Integration to {{ config('idempiere.host') }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Syncing...</span>
            </div>
          </div>
        </div>
      </div>
      
      <table class="table table-hover">
        <thead>
        <tr>
          <th scope="col">Action</th>
          <th scope="col">Order</th>
          <th scope="col">Brand</th>
          <th scope="col">Customer</th>
          <th scope="col">Outlet</th>
          <th scope="col">Created By</th>
        </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            @if($order->c_order_id>0)
            <td><a href="http://112.78.32.216:82/webui/?Action=Zoom&TableName=C_Order&Record_ID={{ $order->c_order_id }}" target="_blank">{{ $order->c_order_no }}</a></td>
            @else
            <td>
              <a href="{{ route('sync.process', $order->order_no) }}" class="btn btn-primary btn-sm">Sync</a>
              <a href="{{ route('sync.delete', $order->order_no) }}" class="btn btn-danger btn-sm">Delete</a>
            </td>
            @endif
            <td>{{ $order->order_no }}</td>
            <td>{{ $order->campaign_name }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->warehouse_name }}</td>
            <td>{{ $order->user_name }} at {{ $order->created_at->format('d/M/Y H:i') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $orders->links() }}
@endsection
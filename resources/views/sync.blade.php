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
          <th scope="col">#</th>
          <th scope="col">Order</th>
              <th scope="col">Created By</th>
          <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <th scope="row">{{ $order->created_at->format('d/M/Y H:i') }}</th>
            <td>{{ $order->order_no }}</td>
            <td>{{ $order->user->name }}</td>
            @if($order->c_order_id>0)
            <td><a href="http://112.78.32.216:82/webui/?Action=Zoom&TableName=C_Order&Record_ID={{ $order->c_order_id }}" target="_blank">{{ $order->c_order_no }}</a></td>
            @else
            <td>
              <a href="{{ route('sync.process', $order->order_no) }}" class="btn btn-primary btn-sm">Sync</a>
              <a href="{{ route('sync.delete', $order->order_no) }}" class="btn btn-danger btn-sm">Delete</a>
            </td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $orders->links() }}
@endsection
@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cancel Orders</h1>
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

<form method="post" action="{{ route('order.cancel') }}">
  @csrf
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Cancel Order</label>
    <div class="col-sm-8">
      <select class="form-control" name="order_id">
        <option value="0">-- Select Order --</option>
        @foreach($syncedOrders as $syncedOrder)
        <option value="{{ $syncedOrder->order_no }}">{{ $syncedOrder->order_no }} - {{ $syncedOrder->date_ordered->format('d M Y') }}</option>
        @endforeach
      </select>
    </div>
    <input class="col-sm-2 btn btn-sm btn-primary" type="submit" value="Process" />
  </div>
</form>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Action</th>
              <th scope="col">Order</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>
                @if($order->status=='processed')
                  <a href="{{ route('order.cancel', $order->order_no) }}" class="btn btn-danger btn-sm mr-2" title="Cancel Order" onclick="return confirm('Are you sure to cancel this order?')">Cancel</a>
                @else
                  <a href="{{ route('order.reactive', $order->order_no) }}" class="btn btn-warning btn-sm mr-2" title="Activate Order" onclick="return confirm('Are you sure to re-active this order?')">Reactivate</a>
                @endif
              </td>
              <td>
                <a href="{{ route('order.detail', $order->order_no) }}">#{{ $order->order_no }}</a><br/>
                @if($order->c_order_id>0)
                <a href="{{ config('idempiere.host') }}/webui/?Action=Zoom&TableName=C_Order&Record_ID={{ $order->c_order_id }}" target="_blank">{{ $order->c_order_no }}</a><br/>
                @endif
                {{ $order->date_ordered->format('d/m/y') }}<br/>
                {{ $order->customer_name}}<br/>
                {{ $order->location_name}}<br/>
                {{ $order->total }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $orders->links() }}
      </div>
@endsection
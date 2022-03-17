@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            @can('create', \App\Models\Order::class)
            <a href="{{ route('order') }}" class="btn btn-sm btn-primary">New Order</a>
            @endcan
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
              <th scope="col">Order</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>
                @if($order->c_order_id)
                  @if($order->is_canceled)
                    @if($order->cancel_message)
                      {{ $order->cancel_message }}
                    @else
                      @can('sync', Auth::user())
                        <a href="{{ route('sync.cancel', $order->order_no) }}" class="btn btn-danger btn-sm mr-2" title="Cancel Order" onclick="return confirm('Are you sure to cancel this order?')"><span data-feather="x"></span></a>
                      @else
                        Waiting for cancelation
                      @endcan
                    @endif
                  @else
                    @can('sync', Auth::user())
                      Synced
                    @else
                      <a href="{{ route('order.cancel', $order->order_no) }}" class="btn btn-danger btn-sm mr-2" title="Cancel Order" onclick="return confirm('Are you sure to cancel this order?')"><span data-feather="x"></span></a>
                      @endcan
                  @endif
                @else
                  <a href="{{ route('order.edit', $order->order_no) }}" class="btn btn-warning btn-sm mr-2" title="Edit Order"><span data-feather="edit"></span></a>
                  <a href="{{ route('order.delete', $order->order_no) }}" class="btn btn-danger btn-sm" title="Delete Order" onclick="return confirm('Are you sure delete this order?')"><span data-feather="trash"></span></a>
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
@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Order</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Back</a>
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

      <h2>#{{ $order->order_no }} - {{ $order->date_ordered->format('d M Y') }}</h2>
      <p>{{ $order->customer_name }} - {{ $order->location_name }}. {{ $order->total }}</p>
      <p>
        @if($order->c_order_id>0)
          - <a href="{{ config('idempiere.host') }}/webui/?Action=Zoom&TableName=C_Order&Record_ID={{ $order->c_order_id }}" target="_blank">{{ $order->c_order_no }}</a>
        @endif
      </p>
      <p>created by {{ $order->user_name }} at {{ $order->created_at->format('d M Y H:i:s') }}</p>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->lines as $line)
            <tr>
              <td>{{ $line->product_code }} - {{ $line->product_name }}</td>
              <td>{{ $line->quantity }} x @ {{ $line->price }}</td>
              <td>{{ $line->total }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection
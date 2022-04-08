@extends('metronic')
@push('scripts')
		<script src="{{ asset('assets/js/report-table.js') }}" type="text/javascript"></script>
@endpush
@section('content')
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

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon2-line-chart"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                Cancel Orders  
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

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

        <!--begin: Search Form -->
        <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
            <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                    <div class="row align-items-center">
                        <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-form__group kt-form__group--inline">
                                <div class="kt-form__label">
                                    <label>Status:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
                    <a href="#" class="btn btn-default kt-hidden">
                        <i class="la la-cart-plus"></i> New Order
                    </a>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
                </div>
            </div>
        </div>

        <!--end: Search Form -->
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">

        <!--begin: Datatable -->
        <table class="kt-datatable" id="html_table" width="100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Order ID</th>
                    <th>Document No</th>
                    <th>Date Ordered</th>
                    <th>Customer Name</th>
                    <th>Location</th>
                    <th title="Status">Status</th>
                    <th>Total</th>
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
                    
                  </td>
                  <td>
                    @if($order->c_order_id>0)
                    <a href="{{ config('idempiere.host') }}/webui/?Action=Zoom&TableName=C_Order&Record_ID={{ $order->c_order_id }}" target="_blank">{{ $order->c_order_no }}</a><br/>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $order->date_ordered->format('d/m/y') }}</td>
                  <td>{{ $order->customer_name}}</td>
                  <td>{{ $order->location_name}}</td>
                  <td>{{ $order->status}}</td>
                  <td>{{ $order->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!--end: Datatable -->
    </div>
</div>
@endsection
@section('null')
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
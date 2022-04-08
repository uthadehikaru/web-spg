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
                Orders  
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        New Order
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">

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
                                <div class="kt-form__control">
                                    <select class="form-control bootstrap-select" id="kt_form_status">
                                        <option value="">All</option>
                                        <option value="draft">Draft</option>
                                        <option value="processing">Processing</option>
                                        <option value="processed">Processed</option>
                                        <option value="cancel">Waiting Cancel</option>
                                        <option value="canceled">Canceled</option>
                                        <option value="error">Error</option>
                                    </select>
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
                  @if($order->status=='draft')
                    <a href="{{ route('order.edit', $order->order_no) }}" class="btn btn-warning btn-sm mr-2" title="Edit Order">Edit</a>
                    <a href="{{ route('order.delete', $order->order_no) }}" class="btn btn-danger btn-sm" title="Delete Order" onclick="return confirm('Are you sure delete this order?')">Delete</a>
                  @elseif($order->status=='cancel')
                    @if(Auth::user()->is_admin)
                      <a href="{{ route('sync.cancel', $order->order_no) }}" class="btn btn-danger btn-sm mr-2" title="Cancel Order" onclick="return confirm('Are you sure to cancel this order?')">Cancel</a>
                    @endif
                  @elseif($order->status=='error')
                    <a href="{{ route('order.edit', $order->order_no) }}" class="btn btn-warning btn-sm mr-2" title="Edit Order">Edit</a>
                    <a href="{{ route('order.delete', $order->order_no) }}" class="btn btn-danger btn-sm" title="Delete Order" onclick="return confirm('Are you sure delete this order?')">Delete</a>
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
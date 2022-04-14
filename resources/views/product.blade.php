@extends('metronic')
@push('scripts')
		<script src="{{ asset('assets/js/product-table.js') }}" type="text/javascript"></script>
@endpush
@section('breadcrumbs')
<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">
    Products Data
</span>
@endsection
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon2-users"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                {{ $total }} Products
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <a href="{{ route('product.sync') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-refresh"></i>
                        Sync
                    </a>
                    <a href="{{ route('product.print') }}" target="_blank" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-print"></i>
                        Print
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
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <th title="Product Code">Value</th>
                    <th title="Product Name">Name</th>
                    <th title="Price">Price</th>
                    <th title="Status">Status</th>
                    <th title="Created At">Synced at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>    
                        <td>{{ $product->value }}</td>
                        <td>{{ $product->name }}</td>
                        <td class="text-right">{{ $product->price }}</td>
                        <td>{{ $product->is_active }}</td>
                        <td>{{ $product->updated_at->format('d/m/y h:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!--end: Datatable -->
    </div>
</div>
@endsection
@section('null')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 bproduct-bottom">
        <h1 class="h2">{{ $total }} Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="{{ route('product.sync') }}" class="btn btn-sm btn-outline-secondary">Sync</a>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Value</th>
              <th scope="col">Name</th>
              <th scope="col">Is Active</th>
              <th scope="col">Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
            <tr>
              <td>{{ $product->created_at->format('d/m/y h:i') }}</td>
              <td>{{ $product->value }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->is_active?'Active':'Inactive' }}</td>
              <td class="text-right">{{ $product->price }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
@endsection
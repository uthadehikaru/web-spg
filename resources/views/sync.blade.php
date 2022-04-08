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

        <div class="alert alert-info" role="alert">
          {{ $jobs }} Queue is processing
        </div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon2-users"></i>
            </span>
            <h3 class="kt-portlet__head-title">
              Integration to {{ config('idempiere.host') }}
            </h3>
        </div>
        @can('sync', Auth::user())
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <a href="{{ route('sync.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-refresh"></i>
                        Sync
                    </a>
                </div>
            </div>
        </div>
        @endcan
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
                  <th>Failed at</th>
                  <th>Error Message</th>
                </tr>
            </thead>
            <tbody>
              @foreach($failedJobs as $job)
              <tr>
                <td>{{ date('d M Y H:i:s',strtotime($job->failed_at)) }}</td>
                <td>{{ Str::words($job->exception, 20) }}</td>
              </tr>
              @endforeach
            </tbody>
        </table>

        <!--end: Datatable -->
    </div>
</div>
@endsection
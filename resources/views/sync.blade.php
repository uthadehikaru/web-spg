@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Integration to {{ config('idempiere.host') }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          @can('sync', Auth::user())
          <a href="{{ route('sync.create') }}" class="btn btn-sm btn-primary"><span data-feather="refresh-cw"></span></a>
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
      <div class="alert alert-info" role="alert">
        {{ $jobs }} Queue is processing
      </div>
      <table class="table table-hover">
        <thead>
        <tr>
          <th scope="col">Failed at</th>
          <th scope="col">Error Message</th>
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
@endsection
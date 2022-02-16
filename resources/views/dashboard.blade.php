@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>
</div>
<div class="row">
    <div class="col-sm">
      <div class="card text-white bg-primary" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">All Orders</h5>
          <p class="card-text">{{ $all }} Orders</p>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card text-white bg-success" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Synced Orders</h5>
          <p class="card-text">{{ $synced }} Orders</p>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card text-white bg-danger" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Unsynced Orders</h5>
          <p class="card-text">{{ $unsynced }} Orders</p>
        </div>
      </div>
    </div>
  </div>
      
@endsection
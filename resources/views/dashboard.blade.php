@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>
</div>
@if(Auth::user()->is_admin)
<div class="row mt-2">
  <div class="col-lg-6 col-sm-6">
    <div class="circle-tile ">
      <a href="#"><div class="circle-tile-heading dark-blue"><span data-feather="users" class="feather-card"></span></div></a>
      <div class="circle-tile-content dark-blue">
        <div class="circle-tile-description text-faded"> Users</div>
        <div class="circle-tile-number text-faded ">{{ $users }}</div>
        <a class="circle-tile-footer" href="{{ route('user') }}">More Info</a>
      </div>
    </div>
  </div>
    
  <div class="col-lg-6 col-sm-6">
    <div class="circle-tile ">
      <a href="#"><div class="circle-tile-heading red"><span data-feather="box" class="feather-card"></span></div></a>
      <div class="circle-tile-content red">
        <div class="circle-tile-description text-faded"> Products </div>
        <div class="circle-tile-number text-faded ">{{ $products }}</div>
        <a class="circle-tile-footer" href="{{ route('product') }}">More Info</a>
      </div>
    </div>
  </div> 
</div> 
@endif
<div class="row">
  <div class="col-sm mt-2">
    <div class="card text-white bg-primary" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">All Orders</h5>
        <p class="card-text">{{ $all }} Orders</p>
      </div>
    </div>
  </div>
  <div class="col-sm mt-2">
    <div class="card text-white bg-success" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Synced Orders</h5>
        <p class="card-text">{{ $synced }} Orders</p>
      </div>
    </div>
  </div>
  <div class="col-sm mt-2">
    <div class="card text-white bg-danger" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Unsynced Orders</h5>
        <p class="card-text">{{ $unsynced }} Orders</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>

.circle-tile {
    margin-bottom: 15px;
    text-align: center;
}
.circle-tile-heading {
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 100%;
    color: #FFFFFF;
    height: 80px;
    margin: 0 auto -40px;
    position: relative;
    transition: all 0.3s ease-in-out 0s;
    width: 80px;
}
.circle-tile-heading .fa {
    line-height: 80px;
}
.circle-tile-content {
    padding-top: 50px;
}
.circle-tile-number {
    font-size: 26px;
    font-weight: 700;
    line-height: 1;
    padding: 5px 0 15px;
}
.circle-tile-description {
    text-transform: uppercase;
}
.circle-tile-footer {
    background-color: rgba(0, 0, 0, 0.1);
    color: rgba(255, 255, 255, 0.5);
    display: block;
    padding: 5px;
    transition: all 0.3s ease-in-out 0s;
}
.circle-tile-footer:hover {
    background-color: rgba(0, 0, 0, 0.2);
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
}
.circle-tile-heading.dark-blue:hover {
    background-color: #2E4154;
}
.circle-tile-heading.green:hover {
    background-color: #138F77;
}
.circle-tile-heading.orange:hover {
    background-color: #DA8C10;
}
.circle-tile-heading.blue:hover {
    background-color: #2473A6;
}
.circle-tile-heading.red:hover {
    background-color: #CF4435;
}
.circle-tile-heading.purple:hover {
    background-color: #7F3D9B;
}
.tile-img {
    text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
}

.dark-blue {
    background-color: #34495E;
}
.green {
    background-color: #16A085;
}
.blue {
    background-color: #2980B9;
}
.orange {
    background-color: #F39C12;
}
.red {
    background-color: #E74C3C;
}
.purple {
    background-color: #8E44AD;
}
.dark-gray {
    background-color: #7F8C8D;
}
.gray {
    background-color: #95A5A6;
}
.light-gray {
    background-color: #BDC3C7;
}
.yellow {
    background-color: #F1C40F;
}
.text-dark-blue {
    color: #34495E;
}
.text-green {
    color: #16A085;
}
.text-blue {
    color: #2980B9;
}
.text-orange {
    color: #F39C12;
}
.text-red {
    color: #E74C3C;
}
.text-purple {
    color: #8E44AD;
}
.text-faded {
    color: rgba(255, 255, 255, 0.7);
}

.feather-card{
width: 60px;
height: 60px;
padding:5px;
}
</style>
@endpush
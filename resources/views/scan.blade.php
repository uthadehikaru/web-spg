@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">New Order</h1>
  <div class="btn-group me-2">
    <button type="submit" id="save" class="btn btn-primary">Save</button>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <div id="qr-reader"></div>
    <input class="form-control mt-2" id="product_code" name="product_code" placeholder="type product code here" />
  </div>
  <div class="col-md-8">
    <h2 class="h2">Products</h2>
    <div class="table-responsive">
    <form method="post" action="{{ route('order') }}" id="scan-form">
        @csrf
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col" width="60%">Product Code</th>
            <th scope="col" >Quantity</th>
          </tr>
        </thead>
        <tbody id="results">
          <tr id="row-template" class="d-none">
            <td scope="row" class="counter">0</td>
            <td><input type="hidden" name="product_code[]" class="product_code" value=""><span class="value"></span></td>
            <td>
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <button class="btn btn-sm btn-outline-secondary decrease" type="button">-</button>
              </div>
              <input type="number" name="quantity[]" class="form-control quantity" value="1">
              <div class="input-group-append">
                <button class="btn btn-sm btn-outline-secondary increase" type="button">+</button>
              </div>
            </div>
            </td>
          </tr>
        </tbody>
      </table>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('scan/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('scan/html5-qrcode-spg.js') }}"></script>
@endpush
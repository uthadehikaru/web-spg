@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">New Order</h1>
        <div class="btn-group me-2">
          <button type="button" class="btn btn-sm btn-outline-secondary">New</button>
          <button type="button" class="btn btn-sm btn-outline-secondary">Save</button>
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
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product</th>
                  <th scope="col">Type</th>
                </tr>
              </thead>
              <tbody id="results">
              </tbody>
            </table>
          </div>
        </div>
      </div>
@endsection

@push('scripts')
<script src="{{ asset('scan/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('scan/html5-qrcode-demo.js') }}"></script>
@endpush
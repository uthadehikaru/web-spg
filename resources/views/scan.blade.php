@extends('metronic')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="{{ asset('scan/html5-qrcode.min.js') }}"></script>
<script src="{{ asset('scan/html5-qrcode-spg.js') }}"></script>
@endpush
@section('toolbar')
    <input type="date" id="date-input" value="{{ $order?$order->date_ordered->format('Y-m-d'):date('Y-m-d') }}" max="{{ date('Y-m-d') }}" 
    {{ $order?'readonly':'' }}/>
    <button type="submit" id="save" class="btn btn-primary">Save</button>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Scan
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="qr-reader"></div>
                <input class="form-control mt-2" id="product_code" name="product_code" placeholder="type product code here" />
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Products
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
            <div class="table-responsive">
            <form method="post" action="{{ $order?route('order.update', $order->order_no):route('order') }}" id="scan-form">
                @csrf
              <input type="hidden" name="date_ordered" id="date-ordered" max="{{ date('Y-m-d') }}" value="">
              <table class="table table-striped table-sm">
                <tbody id="results">
                  <tr id="row-template" class="d-none">
                    <td>
                    <input type="hidden" name="id[]" value="0">
                    <input type="hidden" name="is_deleted[]" class="is_deleted" value="0">
                    <input type="hidden" name="product_code[]" class="product_code" value="">
                    <input type="hidden" name="product_name[]" class="product_name" value="">
                    <div class="row">
                      <div class="col-md-5 value mb-2"></div>
                      <div class="col-md-3 mb-2 form-group row">
                        <label class="col-3 d-block d-md-none">Price</label>
                        <div class="col-9 col-md-12">
                        <input type="text" name="price[]" class="price form-control" value="0">
                        </div>
                      </div>
                      <div class="col-md-3 mb-2 form-group row">
                        <label class="col-3 d-block d-md-none">Quantity</label>
                        <div class="col-9 col-md-12">
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <button class="btn btn-sm btn-outline-secondary decrease" type="button">-</button>
                            </div>
                            <input type="number" name="quantity[]" class="form-control quantity" value="1">
                            <div class="input-group-append">
                              <button class="btn btn-sm btn-outline-secondary increase" type="button">+</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-1 mb-2">
                        <a onClick="delete_row(this)" class="btn btn-danger btn-sm text-white delete"><i class="flaticon-delete"></i></a>
                      </div>
                    </div>
                    </td>
                  </tr>
                  @if($order)
                    @foreach($order->lines as $line)
                    <tr id="{{ $line->id }}" class="">
                      <td>
                      <input type="hidden" name="id[]" value="{{ $line->id }}">
                      <input type="hidden" name="is_deleted[]" class="is_deleted" value="0">
                      <input type="hidden" name="product_code[]" class="product_code" value="{{ $line->product_code }}">
                      <input type="hidden" name="product_name[]" class="product_name" value="{{ $line->product_name }}">
                      <div class="row">
                        <div class="col-md-5 value mb-2">{{ $loop->iteration }}.  {{ $line->product_code }} - {{ $line->product_name }}</div>
                        <div class="col-md-3 mb-2 form-group row">
                          <label class="col-3 d-block d-md-none">Price</label>
                          <div class="col-9 col-md-12">
                          <input type="text" name="price[]" id="price-{{ $line->id }}" class="price form-control" value="{{ $line->getRawOriginal('price') }}">
                          </div>
                        </div>
                        <div class="col-md-3 mb-2 form-group row">
                          <label class="col-3 d-block d-md-none">Quantity</label>
                          <div class="col-9 col-md-12">
                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend">
                                <button class="btn btn-sm btn-outline-secondary decrease" type="button">-</button>
                              </div>
                              <input type="number" name="quantity[]" class="form-control quantity" value="{{ $line->quantity }}">
                              <div class="input-group-append">
                                <button class="btn btn-sm btn-outline-secondary increase" type="button">+</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1 mb-2">
                          <a onClick="delete_line(this)" class="btn btn-danger btn-sm"><i class="flaticon-delete"></i></a>
                        </div>
                      </div>
                      </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
              </table>
              </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('null')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">{{ $order?'Edit':'New' }} Order {{ $order?'#'.$order->order_no:'' }}</h1>
  <div class="btn-group me-2">
    <input type="date" id="date-input" value="{{ $order?$order->date_ordered->format('Y-m-d'):date('Y-m-d') }}" max="{{ date('Y-m-d') }}" 
    {{ $order?'readonly':'' }}/>
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
    <form method="post" action="{{ $order?route('order.update', $order->order_no):route('order') }}" id="scan-form">
        @csrf
      <input type="hidden" name="date_ordered" id="date-ordered" max="{{ date('Y-m-d') }}" value="">
      <table class="table table-striped table-sm">
        <tbody id="results">
          <tr id="row-template" class="d-none">
            <td>
            <input type="hidden" name="id[]" value="0">
            <input type="hidden" name="is_deleted[]" class="is_deleted" value="0">
            <input type="hidden" name="product_code[]" class="product_code" value="">
            <input type="hidden" name="product_name[]" class="product_name" value="">
            <div class="row">
              <div class="col-md-5 value mb-2"></div>
              <div class="col-md-3 mb-2 form-group row">
                <label class="col-3 d-block d-md-none">Price</label>
                <div class="col-9 col-md-12">
                <input type="text" name="price[]" class="price form-control" value="0">
                </div>
              </div>
              <div class="col-md-3 mb-2 form-group row">
                <label class="col-3 d-block d-md-none">Quantity</label>
                <div class="col-9 col-md-12">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <button class="btn btn-sm btn-outline-secondary decrease" type="button">-</button>
                    </div>
                    <input type="number" name="quantity[]" class="form-control quantity" value="1">
                    <div class="input-group-append">
                      <button class="btn btn-sm btn-outline-secondary increase" type="button">+</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1 mb-2">
                <a onClick="delete_row(this)" class="btn btn-danger btn-sm delete"><span data-feather="trash"></span></a>
              </div>
            </div>
            </td>
          </tr>
          @if($order)
            @foreach($order->lines as $line)
            <tr id="{{ $line->id }}" class="">
              <td>
              <input type="hidden" name="id[]" value="{{ $line->id }}">
              <input type="hidden" name="is_deleted[]" class="is_deleted" value="0">
              <input type="hidden" name="product_code[]" class="product_code" value="{{ $line->product_code }}">
              <input type="hidden" name="product_name[]" class="product_name" value="{{ $line->product_name }}">
              <div class="row">
                <div class="col-md-5 value mb-2">{{ $loop->iteration }}.  {{ $line->product_code }} - {{ $line->product_name }}</div>
                <div class="col-md-3 mb-2 form-group row">
                  <label class="col-3 d-block d-md-none">Price</label>
                  <div class="col-9 col-md-12">
                  <input type="text" name="price[]" id="price-{{ $line->id }}" class="price form-control" value="{{ $line->getRawOriginal('price') }}">
                  </div>
                </div>
                <div class="col-md-3 mb-2 form-group row">
                  <label class="col-3 d-block d-md-none">Quantity</label>
                  <div class="col-9 col-md-12">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <button class="btn btn-sm btn-outline-secondary decrease" type="button">-</button>
                      </div>
                      <input type="number" name="quantity[]" class="form-control quantity" value="{{ $line->quantity }}">
                      <div class="input-group-append">
                        <button class="btn btn-sm btn-outline-secondary increase" type="button">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-1 mb-2">
                  <a onClick="delete_line(this)" class="btn btn-danger btn-sm"><span data-feather="trash"></span></a>
                </div>
              </div>
              </td>
            </tr>
            @endforeach
            @endif
        </tbody>
      </table>
      </form>
    </div>
  </div>
</div>
@endsection
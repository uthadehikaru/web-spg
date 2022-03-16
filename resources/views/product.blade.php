@extends('layout')
@section('content')
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
        {{ $products->links() }}
      </div>
@endsection
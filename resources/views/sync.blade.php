@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Integration</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Syncing...</span>
            </div>
          </div>
        </div>
      </div>
      
      <table class="table table-hover">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Order</th>
          <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>ORD-00001</td>
          <td>Not Synced</td>
        </tr>
        
        <tr class="table-primary">
          <th scope="row">2</th>
          <td>ORD-00002</td>
          <td>Processing</td>
        </tr>
        <tr class="table-success">
          <th scope="row">3</th>
          <td>ORD-00003</td>
          <td>Synced</td>
        </tr>
        <tr class="table-danger">
          <th scope="row">4</th>
          <td>ORD-00005</td>
          <td>Failed</td>
        </tr>
        </tbody>
      </table>
@endsection
@extends('layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 buser-bottom">
        <h1 class="h2">{{ $total }} Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="{{ route('user.sync') }}" class="btn btn-sm btn-outline-secondary">Sync</a>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">AD_User_ID</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{ $user->created_at->format('d/m/y h:i') }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->is_admin?'Admin':$user->user_id }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{ $users->links() }}
      </div>
@endsection
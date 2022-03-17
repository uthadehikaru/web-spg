<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Zuhri">
    <meta name="base_url" content="{{ url('') }}">
    <title>{{ config('app.name') }}</title>

    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Bootstrap core CSS -->
<link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav d-none d-md-block">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="{{ route('logout') }}">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#">
              Hi, {{ Auth::user()->name }} !
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          @can('create', \App\Models\Order::class)
          <li class="nav-item">
            <a class="nav-link" href="{{ route('order') }}">
              <span data-feather="file"></span>
              New Order
            </a>
          </li>
          @endcan
          <li class="nav-item">
            <a class="nav-link" href="{{ route('report') }}">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          @can('sync', Auth::user())
          <li class="nav-item">
            <a class="nav-link" href="{{ route('sync') }}">
              <span data-feather="refresh-cw"></span>
              Integrations
            </a>
          </li>
          @endcan
          @can('list', Auth::user())
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user') }}">
              <span data-feather="users"></span>
              Users
            </a>
          </li>
          @endcan
          @can('list', \App\Models\Product::class)
          <li class="nav-item">
            <a class="nav-link" href="{{ route('product') }}">
              <span data-feather="box"></span>
              Products
            </a>
          </li>
          @endcan
          <li class="nav-item d-block d-md-none">
            <a class="nav-link" href="{{ route('logout') }}">
              <span data-feather="lock"></span>
              Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      @yield('content')

    </main>
  </div>
</div>


      <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="{{ asset('assets/dashboard.js') }}"></script>
      @stack('scripts')
  </body>
</html>

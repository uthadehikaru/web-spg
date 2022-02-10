<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>{{ config('app.name') }}</title>

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
    <link href="{{ asset('assets/starter-template.css') }}" rel="stylesheet">
  </head>
  <body>
    
<div class="col-lg-8 mx-auto p-3 py-md-5">
  <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
      <span class="fs-4">{{ config('app.name') }}</span>
    </a>
  </header>

  <main>
    @yield('content')
  </main>
  <footer class="pt-5 my-5 text-muted border-top">
    Created by zuhri &middot; &copy; 2022
  </footer>
</div>


    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>

      
  </body>
</html>

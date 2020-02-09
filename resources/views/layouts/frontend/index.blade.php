<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap-custom.css')}}">
    <!-- Our CSS -->
    <link rel="stylesheet" href="{{asset('css/style_home.css')}}">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <title>SIMPPDB</title>
  </head>
  <body>
    <!-- navbar -->
<nav class="navbar navbar-expand-md navbar-light">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{Request::route()->getName() == 'home' ? 'active' : ''}}">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>
            <li class="nav-item {{Request::route()->getName() == 'video' ? 'active' : ''}}">
                <a class="nav-link" href="#">Video</a>
            </li>
            <li class="nav-item {{Request::route()->getName() == 'artikel' ? 'active' : ''}}">
                <a class="nav-link" href="#">Artikel</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">SIMPPDB Madrasah Kota Banda Aceh</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
        @if (Auth::user())
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">Dashboard</a>
        </li>
        @else
            <!-- Login -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <form class="px-4 py-3" method="POST" enctype="multipart/form-data" action="{{route('auth.login')}}">
                @csrf
                <div class="form-group">
                <label for="exampleDropdownFormEmail1">NIK</label>
                <input type="text" name="NIK" class="form-control" id="exampleDropdownFormEmail1" placeholder="99334512377213">
                </div>
                <div class="form-group">
                <label for="exampleDropdownFormPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
                </div>
                <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck" name="remember_me">
                <label class="form-check-label" for="dropdownCheck">
                    Ingat Saya
                </label>
                </div>
                <button type="submit" class="btn btn-primary">Masuk</button>
            </form>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('auth.show.register')}}">Tidak Ada Akun? Daftar</a>
            <a class="dropdown-item" href="#">Lupa Password?</a>
            </div>
        </li>
        <!-- /Login -->
        @endif
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <form class="form-inline px-4">
                <input class="form-control mr-sm-2" type="search" placeholder="Kata Kunci" aria-label="Search">
                <button class="btn btn-sm btn-outline-info my-2 my-sm-0" type="submit">Cari</button>
              </form>
            </div>
          </li>
        </ul>
    </div>
</nav>
    <!-- Navbar -->
<div class="container">
  @yield('content')
</div>

<br>
<br>
<br>
<footer class="fixed-bottom bg-dark text-light text-center pt-2">Copyright © 2019 | Kemenag Kota Banda Aceh Powered By <a href=""><u>CODINGERS.ID</u></a>
</footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @include('sweetalert::alert')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
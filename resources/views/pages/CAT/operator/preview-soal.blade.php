<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
<nav class="navbar navbar-expand-md navbar-dark navsgrad">
    <div class="mx-auto order-0">
        <a class="navbar-brand mr-auto" href="#">SIMPPDB Madrasah Kota Banda Aceh</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> {{Auth::user()->username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#"><i class="fas fa-door-open"></i> Keluar Halaman Ujian</a>
                </div>
          </li>
        </ul>
    </div>
</nav>
    <!-- Navbar -->
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1 class="px-5">Soal No. <span class="badge badge-primary">{{$data->nomor_soal}}</span></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <h4 class="px-5 text-secondary"><i class="fas fa-hourglass-half"></i> Sisa Waktu <span class="badge badge-warning">00:00:00</span></h4>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-12 col-sm-6 col-md-8">
            <form action="#" method="POST">
                @csrf
                <input type="hidden" value="#" name="#" required>
            <div class="card ml-auto">
              <div class="card-body">
                {!!$data->soal!!}
                <br>
                @if ($data->gambar != NULL)
                    <img src="{{Dits::imageUrl($data->gambar)}}" width="200px" height="280px"  alt="">
                @endif
                <br><br>
                <div class="form-check">
                  <input class="form-check-input" name="jawaban[]" type="radio" name="exampleRadios" id="exampleRadios1" value="a">
                  <label class="form-check-label" for="exampleRadios1">
                    A. {{$data->a}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" name="jawaban[]" type="radio" name="exampleRadios" id="exampleRadios2" value="b">
                  <label class="form-check-label" for="exampleRadios2">
                    B. {{$data->b}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" name="jawaban[]" type="radio" name="exampleRadios" id="exampleRadios3" value="c">
                  <label class="form-check-label" for="exampleRadios3">
                    C. {{$data->c}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" name="jawaban[]" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                  <label class="form-check-label" for="exampleRadios4">
                    D. {{$data->d}}
                  </label>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end">
                {{-- @if ($finish == true)
                    <input type="hidden" name="finish" value="finish">
                    <button type="submit" class="btn btn-info mt-2">Selesai</button>
                @else
                    <button type="submit" class="btn btn-warning mt-2">Selanjutnya</button>
                @endif --}}
            </div>
        </form>
        </div>
</div>
<br><br><br><br><br><br>
<footer class="fixed-bottom bg-dark text-light text-center pt-2">Copyright © 2019 | Kemenag Kota Banda Aceh Powered By <a href=""><u>CODINGERS.COM</u></a>
</footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
{{--
    This Template For simppdbmadrasah.com
    Builded At March 2020
    =====================================
    Builded Under License CODINGERS.ID
    Designer Frandika Septa
    Developer Aditya Nurdin
    You Can Change Anything, But You Not Allowed Remove This Credit
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="index, follow" />
    <meta name="author" content="https://codingers.id/ | Frandika Septa" />
    <meta name="application-name" content="SIM PPDB MADRASAH KOTA BANDA ACEH" />
    @stack('title')
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon/ms-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('img/favicon/manifest.json') }}" />
    <link rel="stylesheet" type="text/css" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/owlcarousel/assets/owl.carousel.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frandikasepta.css?v=170320') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/res_frandikasepta.css?v=170320') }}" />
</head>

<body>
    {{--  navbar  --}}
    <nav class="navbar navbar-expand-md navbar-transparan fixed-top" id="nav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo-min.png') }}" alt="SIM PPDB Madrasah Kota Banda Aceh">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.videos') }}#tag-videos">Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.artikel') }}#tag-articles">Artikel</a>
                    </li>
                    <div class="sparator"></div>
                    @if (Auth::check())
                    <li class="nav-item nav_register">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa fa-desktop"></i> Dashboard</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}#tag-login">Login</a>
                    </li>
                    <li class="nav-item nav_register">
                        <a class="nav-link" href="{{ route('auth.register') }}#tag-register"><i class="fa fa-desktop"></i>
                            Register</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    {{--  navbar  --}}
    {{--  header  --}}
    <header data-scroll-index="1">
        <div class="container">
            <div class="title">
                <h1>Sistem Informasi Manajamen</h1>
                <h1>Pendaftaran peserta didik baru madrasah</h1>
                <h1 class="kota">kota banda aceh</h1>
                <p>Website Untuk Melakukan Pendaftaran Peserta Didik Baru<br />
                    Pada Madrasah Di Kota Banda Aceh Secara ONLINE
                </p>
                <a href="{{ route('auth.register') }}#tag-register"><i class="fa fa-desktop"></i> DAFTAR
                    SEKARANG</a>
            </div>
        </div>
    </header>
    {{--  header  --}}
    @yield('content')
    {{--  footer  --}}
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="copyright">
                        <h6>Copyright &copy; 2019-{{ date('Y') }} | Kemenag Kota Banda Aceh</h6>
                        <h6>Made With <i class="icon ion-heart"></i> By <a target="_BLANK"
                                href="http://codingers.id/">CODINGERS.ID</a></h6>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="footer_menus">
                        <ul class="nav justify-content-lg-end justify-content-sm-center justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home.videos') }}#tag-videos">Video</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home.artikel') }}#tag-articles">Artikel</a>
                            </li>
                            <div class="sparator"></div>
                            @if (Auth::check())
                            <li class="nav-item nav_register">
                                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa fa-desktop"></i> Dashboard</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.login') }}#tag-login">Login</a>
                            </li>
                            <li class="nav-item nav_register">
                                <a class="nav-link" href="{{ route('auth.register') }}#tag-register"><i class="fa fa-desktop"></i>
                                    Register</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{--  Gotoup  --}}
        <a href="javascript:void(0);" class="gotoup invisible" data-scroll-goto="1"><i class="fa fa-chevron-up"></i></a>
        {{--  Gotoup  --}}
    </footer>
    {{--  footer  --}}

    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/scrollIt/scrollIt.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/owlcarousel/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frandikasepta.js?v=020420') }}"></script>
    @include('sweetalert::alert')
<script type="text/javascript">
$(document).ready(function() {
    var cat_ujian = getCookie('cat_ujian');
    var kode_soal = getCookie('kode_soal');
    if(cat_ujian!="" && kode_soal!=""){
        document.location="{!! url('/') !!}/CAT/store/ujian/"+kode_soal;
    }else{
        document.cookie = 'minutes=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/CAT/store/ujian';
        document.cookie = 'seconds=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/CAT/store/ujian';
        document.cookie = 'cat_ujian=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
        document.cookie = 'kode_soal=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    }
});
</script>
</body>

</html>

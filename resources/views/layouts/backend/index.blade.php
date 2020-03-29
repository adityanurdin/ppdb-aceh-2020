@if (\session('cat_ujian')=="start")
<script>document.location="{!! route('cat.ujian', \session('kode_soal')) !!}"</script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="ROBOTS" content="noindex, nofollow" />
    <meta name="author" content="https://codingers.id/ | Frandika Septa" />
    <meta name="application-name" content="SIM PPDB MADRASAH KOTA BANDA ACEH" />
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
    <title>{{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM
        PPDB Madrasah Kota Banda Aceh</title>
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/dist/css/bootstrap-custom-new.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bootstrap/dist/css/style-new.css') }}?v={{ date('ymdHis') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}">
    @yield('css')
</head>

<body>
    <div class="wrapper">
        {{--  Sidebar   --}}
        @include('layouts.backend.addon.sidebar')
        {{--  Sidebar  --}}
        {{--  Page Content   --}}
        <div id="content">
            {{--  Top  --}}
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <h3 class="mx-auto">
                        @yield('headers')
                    </h3>
                </div>
            </nav>
            <hr>
            <div class="table-responsive">
                @yield('breadchumb')
            </div>
            {{--  Top  --}}
            @yield('content')
        </div>
        @yield('modal')
    </div>
    <div class="table-responsive">
        @include('sweetalert::alert')
    </div>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/moment/moment.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    @stack('script')
</body>

</html>
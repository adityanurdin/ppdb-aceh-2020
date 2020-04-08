@extends('layouts.frontend.index')

@push('title')
<title>Halaman Register | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
    content="Halaman Register, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
    content="Halaman Register, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- register --}}
<section id="sec_login">
    <div id="pattern_register">
        <div class="container" id="tag-register">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-sm-12 offset-sm-0">
                    <div class="div_form">
                        <div class="logo">
                            <img src="{{ asset('img/logo-min.png') }}" alt="SIM PPDB Madrasah Kota Banda Aceh | Login">
                        </div>
                        <div class="title">
                            <h1>Halaman Register</h1>
                        </div>
                        {{-- <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="NIK">NIK *</label>
                                <input type="text" class="form-control @error('NIK') is-invalid @enderror" id="NIK"
                                    name="NIK" placeholder="NIK Anda..." autocomplete="off" maxlength="16" required>
                                <small class="form-text text-muted">NIK Peserta Adalah <b>NIK</b>.</small>
                                @error('NIK')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Email Anda..." autocomplete="off" maxlength="100" required>
                    @error('email')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password Anda..." autocomplete="off"
                            maxlength="100" required>
                        @error('password')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password_confirmation">Konfirmasi Password *</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Konfirmasi Password Anda..." autocomplete="off"
                            maxlength="100" required>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-desktop"></i>
                        Register</button>
                </div>
                </form> --}}
                <div class="alert alert-info mt-2" role="alert">
                    <h5><i class="fa fa-info-circle"></i> INFORMASI!</h5>
                    <p>Penerimaan PPDB Melalui Website <b>SIM PPDB Madrasah Kota Banda Aceh</b> Dilaksanakan Pada
                        Tanggal 1-15 Juni 2020 Serentak Untuk Semua Jenjang.</p>
                </div>
                <div class="form-group mt-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-info float-right"><i class="fa fa-home"></i> Kembali Ke Home</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
{{-- register --}}
@endsection

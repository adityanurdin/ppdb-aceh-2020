@extends('layouts.frontend.index')

@push('title')
<title>Halaman Login | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="Halaman Login, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="Halaman Login, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- login --}}
<section id="sec_login">
    <div id="pattern_login">
        <div class="container" id="tag-login">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-sm-12 offset-sm-0">
                    <div class="div_form">
                        <div class="logo">
                            <img src="{{ asset('img/logo-min.png') }}" alt="SIM PPDB Madrasah Kota Banda Aceh | Login">
                        </div>
                        <div class="title">
                            <h1>Halaman Login</h1>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="NIK">Username/NIK *</label>
                                <input type="text" class="form-control @error('NIK') is-invalid @enderror" id="NIK" name="NIK"
                                    placeholder="Username/NIK Anda..." autocomplete="off" maxlength="16" required>
                                <small class="form-text text-muted">Username Peserta Adalah <b>NIK</b>.</small>
                                @error('NIK')
                                <div class="invalid-feedback text-left">
                                  <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                    placeholder="Password Anda..." autocomplete="off" maxlength="100" required>
                                    @error('password')
                                    <div class="invalid-feedback text-left">
                                      <label>{{ $message }}</label>
                                    </div>
                                    @enderror
                            </div>
                            <div class="form-group icheck-primary">
                                <input type="checkbox" id="remember_me" name="remember_me">
                                <label for="remember_me">Remember Me!</label>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in-alt"></i>
                                    LOGIN</button>
                            </div>
                            <div class="reset_form">
                                <p>Lupa Password Anda? <a href="{{ route('auth.lupas') }}">KLIK DISINI</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- login --}}
@endsection
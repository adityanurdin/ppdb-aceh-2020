@extends('layouts.frontend.index')

@push('title')
<title>Halaman Reset Password | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="Halaman Reset Password, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="Halaman Reset Password, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- Reset Password --}}
<section id="sec_login">
  <div id="pattern_login">
    <div class="container" id="tag-reset">
      <div class="row">
        <div class="col-md-6 offset-md-3 col-sm-12 offset-sm-0">
          <div class="div_form">
            <div class="logo">
              <img src="{{ asset('img/logo-min.png') }}" alt="SIM PPDB Madrasah Kota Banda Aceh | Lupa Password">
            </div>
            <div class="title">
              <h1>Halaman Reset Password</h1>
            </div>
            <form action="" method="POST">
              @csrf
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Anda..."
                  autocomplete="off" maxlength="100" required>
                @error('email')
                <div class="invalid-feedback text-left">
                  <label>{{ $message }}</label>
                </div>
                @enderror
              </div>
              <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa fa-history"></i> Reset Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- Reset Password --}}
@endsection
@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-blue">
    <h3>Registrasi Peserta PPDB Madrasah</h3>
  </div>
  <div class="row">
    <div class="col-md">
      <img class="img-fluid" src="{{asset('img/logo_1-min.png')}}" width="400px">
    </div>
    <div class="col-md">
      <form action="{{route('auth.register')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="inputNik">NIK</label>
          <input type="number" name="NIK" class="form-control" id="inputNik" placeholder="99321312312312">
        </div>
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="contoh@email.com">
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputPassword">Password</label>
            <input type="password" name="password" class="form-control" id="inputEmail4" placeholder="Password">
          </div>
          <div class="form-group col-md-6">
            <label for="inputCPassword">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="inputCPassword" placeholder="Password">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
      </form>
    </div>
  </div>
@endsection
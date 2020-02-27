@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-blue">
    <h3>Lupa Password</h3>
  </div>
  <div class="row">
    <div class="col-md">
      <img class="img-fluid" src="{{asset('img/logo_1-min.png')}}" width="400px">
    </div>
    <div class="col-md">
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <form action="{{route('auth.proses-lupas')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-5">
          <label for="inputEmail">Email</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="contoh@email.com">
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
      </form>
    </div>
  </div>
@endsection
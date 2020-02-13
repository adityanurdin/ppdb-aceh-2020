@extends('layouts.frontend.index')

@section('content')
<div class="row">
  <div class="col mt-3">
    {{-- <img src="{{asset('img/logo_1-min.png')}}" class="img-fluid rounded mx-auto d-block" width="300px"> --}}
    <img src="https://simppdbaceh.frandikasepta.com/assets/img/banner.png" class="img-fluid rounded mx-auto d-block">
  </div>
</div>
<hr>
<h3>Postingan Terbaru</h3>
<div class="row">
  <div class="col-sm">
    <div class="bd-callout bd-callout-blue">
      <p class="mb-0"><i class="fas fa-play-circle"></i> Video</p>
    </div>
    <a href="">
      <div class="card mb-3">
        <img class="card-img-top" src="{{asset('img/no-img.jpg')}}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
          <small class="text-muted"><i class="fas fa-user-edit"></i> Author</small>
          <br>
          <small class="text-muted"><i class="fas fa-clock"></i> Last updated 3 mins ago</small>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm">
    <div class="bd-callout bd-callout-green">
      <p class="mb-0"><i class="fas fa-file-alt"></i> Artikel</p>
    </div>
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
        <img src="{{asset('img/no-img.jpg')}}" class="img-fluid rounded float-left" width="200px">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">List group item heading</h5>
          <small class="text-muted">3 days ago</small>
        </div>
        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
        <small class="text-muted"><i class="fas fa-user-edit"></i> Donec id elit non mi porta.</small>
      </a>
      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
        <img src="{{asset('img/no-img.jpg')}}" class="img-fluid rounded float-left" width="200px">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">List group item heading</h5>
          <small class="text-muted">3 days ago</small>
        </div>
        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
        <small class="text-muted"><i class="fas fa-user-edit"></i> Donec id elit non mi porta.</small>
      </a>
    </div>
  </div>
</div>
@endsection
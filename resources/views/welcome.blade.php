@extends('layouts.frontend.index')

@section('content')
<div class="row">
  <div class="col mt-3">
    {{-- <img src="{{asset('img/logo_1-min.png')}}" class="img-fluid rounded mx-auto d-block" width="300px"> --}}
    <img src="{{asset('img/banner.jpg')}}" class="img-fluid rounded mx-auto d-block">
  </div>
</div>
<hr>
<h3>Postingan Terbaru</h3>
<div class="row">
  <div class="col-sm">
    <div class="bd-callout bd-callout-blue">
      <p class="mb-0"><i class="fas fa-play-circle"></i> Video</p>
    </div>
    @if (isset($video))    
    <a href="{{route('home.video.slug' , $video->slug_video)}}">
      <div class="card mb-3">
        <div class="table-responsive">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $video->url_video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$video->judul_video}}</h5>
          <p class="card-text">{{substr($video->deskripsi_video , 0 ,45)  }} .. Read More</p>
          <small class="text-muted"><i class="fas fa-user-edit"></i> {{$publisher->operator['nama_operator']}}</small>
          <br>
          <small class="text-muted"><i class="fas fa-clock"></i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $video->created_at)->toFormattedDateString() }}</small>
        </div>
      </div>
    </a>
    @else 
    Tidak ada Video 
    @endif

  </div>
  <div class="col-sm">
    <div class="bd-callout bd-callout-green">
      <p class="mb-0"><i class="fas fa-file-alt"></i> Artikel</p>
    </div>
    <div class="list-group">
      @if (isset($artikel))
          @foreach ($artikel as $item)
              
          <a href="{{route('home.artikel.slug' , $item->slug_artikel)}}" class="list-group-item list-group-item-action flex-column align-items-start">
            <img src="{{ Dits::imageUrl($item->thumbnail_artikel) }}" class="img-fluid rounded float-left" width="200px">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{$item->judul_artikel}}</h5>
              <small class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->toFormattedDateString() }}</small>
            </div>
            <p class="mb-1">{!! substr($item->deskripsi_artikel, 0 , 50) !!}</p>
          </a>

          @endforeach
      @endif
    </div>
  </div>
</div>
@endsection
@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-blue">
    <p class="mb-0"><i class="fas fa-play-circle"></i> Video</p>
  </div>

  <div class="row">
      @foreach ($video as $item)  
      @foreach ($publisher as $row)    
        <div class="col-6 col-md-4">
            <a href="{{route('home.video.slug' , $item->slug_video)}}">
            <div class="card mb-3">
                <img class="card-img-top" src="{{Dits::imageUrl($item->thumbnail_video)}}" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">{{strlen($item->judul_video) > 30 ? substr($item->judul_video , 0 , 27).' ...'  : $item->judul_video}}</h5>
                <small class="text-muted"><i class="fas fa-user-edit"></i> {{$row->operator['nama_operator']}}</small>
                <br>
                <small class="text-muted"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->toFormattedDateString() }}</small>
                </div>
            </div>
            </a>
        </div>
      @endforeach
      @endforeach
  </div>
@endsection
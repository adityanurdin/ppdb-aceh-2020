@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-green">
    <p class="mb-0"><i class="fas fa-play-circle"></i> Artikel</p>
  </div>

  <div class="row">
    @foreach ($artikel as $item)  
    @foreach ($publisher as $row)    
      <div class="col-6 col-md-4">
          <a href="{{route('home.artikel.slug' , $item->slug_artikel)}}">
          <div class="card mb-3">
              <img class="card-img-top" src="{{Dits::imageUrl($item->thumbnail_artikel)}}" alt="Card image cap">
              <div class="card-body">
              <h5 class="card-title">{{strlen($item->judul_artikel) > 30 ? substr($item->judul_artikel , 0 , 27).' ...'  : $item->judul_artikel}}</h5>
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
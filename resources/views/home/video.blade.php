@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-blue">
    <p class="mb-0"><i class="fas fa-play-circle"></i> [Now Playing]  {{$data->judul_video}}</p>
  </div>
  <div class="table-responsive">
      <iframe width="1110" height="512" src="https://www.youtube.com/embed/{{ $data->url_video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>
<div class="card">
    <div class="card-body">
        <h5>{{$data->judul_video}}</h5>
        <h6>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString() }}</h6>
        <small class="text-muted"><i class="fas fa-user-edit"></i> {{$publisher->operator['nama_operator']}}</small>
        <hr>
        {{$data->deskripsi_video}}
    </div>
</div>
@endsection
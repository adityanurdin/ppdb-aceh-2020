@extends('layouts.frontend.index')

@section('content')
<div class="bd-callout bd-callout-green">
    <p class="mb-0"><i class="fas fa-file-alt"></i> [Now Reading] {{$artikel->judul_artikel}}</p>
  </div>
  <div class="container">
    <div class="table-responsive">
      {!! $artikel->isi_artikel !!}
    </div>
  </div>
@endsection
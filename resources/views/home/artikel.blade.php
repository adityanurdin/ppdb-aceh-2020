@extends('layouts.frontend.index')

@push('title')
<title>{{ $data->judul_artikel }}</title>
<meta name="description"
content="{{ $data->judul_artikel }}, {{ $data->deskripsi_artikel }}, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="{{ $data->judul_artikel }}, {{ $data->deskripsi_artikel }}, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- open_artikel --}}
<section id="sec_open_artikel">
  <div class="container" id="tag-articles">
    {{-- title section --}}
    <div class="title_sec" id="open">
      <h1>{{ $data->judul_artikel }}</h1>
      <span><i class=" fa fa-user"></i>{{ $nama }}</span>
      <span class="sparator"></span>
      <span><i class="fa fa-calendar-alt"></i>{{ date('d/m/y H:i',strtotime($data->created_at)) }}</span>
    </div>
    {{-- title section --}}
    <div class="thumb_artikel">
      <img src="{{ Dits::imageUrl($data->thumbnail_artikel)}}" alt="{{ $data->judul_artikel }}">
    </div>
    {{-- Isi Artikel --}}
    <div class="isi_artikel">
      {!! $data->isi_artikel !!}
    </div>
    {{-- Isi Artikel --}}
  </div>
</section>
{{-- open_artikel --}}
{{-- related_artikel --}}
<section id="sec_related_artikel">
  <div class="container">
    {{-- title section --}}
    <div class="title_sec">
      <h1>Related Artikel</h1>
    </div>
    {{-- title section --}}
    {{-- Item Owl Carousel --}}
    <div id="related_artikel_list" class="owl-carousel">
      @if (count($artikel)>0)
      {{--  item  --}}
      @foreach ($artikel as $datas)
      @php
      $publisher = \App\User::where('username' , $datas->kode_user)->first();
      if($publisher->role=="Admin System"){
      $namas = "Admin System";
      }else{
      $namas = $publisher->operator->nama_operator;
      }
      @endphp
      <div class="col-12 p-2 item">
        <div class="thumb_artikel">
          <img src="{{ Dits::imageUrl($datas->thumbnail_artikel)}}" alt="{{ $datas->judul_artikel }}">
        </div>
        <div class="related_artikel_desc">
          <a href="{{ route('home.artikel.slug',['slug'=>$datas->slug_artikel]) }}#open">
            <h1>{{ $datas->judul_artikel }}</h1>
          </a>
          <span><i class="fa fa-user"></i>{{ $namas }}</span>
          <span class="sparator"></span>
          <span><i class="fa fa-calendar-alt"></i>{{ date('d/m/y H:i',strtotime($datas->created_at)) }}</span>
        </div>
      </div>
      @endforeach
      {{--  item  --}}
      @else
      <div class="col-12 alert alert-warning" role="alert">
        <h3>Mohon Maaf, Data Artikel Tidak Ditemukan!</h3>
      </div>
      @endif
    </div>
    {{-- Item Owl Carousel --}}
  </div>
</section>
{{-- related_artikel --}}
@endsection
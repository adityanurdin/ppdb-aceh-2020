@extends('layouts.frontend.index')

@push('title')
<title>KATEGRI ARTIKEL | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- <div class="bd-callout bd-callout-green">
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
    <h5 class="card-title">
      {{strlen($item->judul_artikel) > 30 ? substr($item->judul_artikel , 0 , 27).' ...'  : $item->judul_artikel}}</h5>
    <small class="text-muted"><i class="fas fa-user-edit"></i> {{$row->operator['nama_operator']}}</small>
    <br>
    <small class="text-muted"><i class="fas fa-clock"></i>
      {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->toFormattedDateString() }}</small>
  </div>
</div>
</a>
</div>
@endforeach
@endforeach
</div> --}}

{{-- list_artikel --}}
<section id="sec_list_artikel">
  <div class="container">
    {{-- title section --}}
    <div class="title_sec">
      <h1>List Artikel</h1>
    </div>
    {{-- title section --}}
    <div id="list_artikel">
      <div class="row">
        @if (count($artikel)>0)
        {{--  item  --}}
        @foreach ($artikel as $data)
        @php
        $publisher = \App\User::where('username' , $data->kode_user)->first();
        if($publisher->role=="Admin System"){
        $nama = "Admin System";
        }else{
        $nama = $publisher->operator->nama_operator;
        }
        @endphp
        <div class="col-md-4 col-sm-12 p-2">
          <a href="{{ route('home.artikel.slug',['slug'=>$data->slug_artikel]) }}">
            <div class=" list_artikel">
              <div class="thumb_artikel">
                @if ($data->thumbnail_artikel=="")
                    <img src="{{ asset('img/logo-min.png') }}"
                        alt="{{ $data->judul_artikel }}">
                @else
                <img src="{{ Dits::imageUrl($data->thumbnail_artikel) }}"
                    alt="{{ $data->judul_artikel }}">
                @endif
              </div>
              <div class="list_artikel_desc">
                <h1>{{ $data->judul_artikel }}</h1>
                <span><i class="fa fa-user"></i>{{ $nama }}</span>
                <span class="sparator"></span>
                <span><i
                        class="fa fa-calendar-alt"></i>{{ date('d/m/y H:i',strtotime($data->created_at)) }}</span>
              </div>
            </div>
          </a>
        </div>
        @endforeach
        {{--  item  --}}
        @else
        <div class="col-12 alert alert-warning" role="alert">
            <h3>Mohon Maaf, Data Artikel Tidak Ditemukan!</h3>
        </div>
        @endif
      </div>
    </div>
    {{-- Pagination --}}
    <div style="text-align: center !important;">
      {{ $artikel->links() }}
    </div>
    {{-- Pagination --}}
  </div>
</section>
{{-- list_artikel --}}
@endsection
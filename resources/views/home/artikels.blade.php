@extends('layouts.frontend.index')

@push('title')
<title>KATEGORI ARTIKEL | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- list_artikel --}}
<section id="sec_list_artikel">
  <div class="container" id="tag-articles">
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
          <a href="{{ route('home.artikel.slug',['slug'=>$data->slug_artikel]) }}#open">
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
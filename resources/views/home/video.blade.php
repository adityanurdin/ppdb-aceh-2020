@extends('layouts.frontend.index')

@push('title')
<title>{{ $data->judul_video }}</title>
<meta name="description"
    content="{{ $data->judul_video }}, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
    content="{{ $data->judul_video }}, SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{-- open_video --}}
<section id="sec_open_video">
    <div class="container" id="tag-videos">
        {{-- title section --}}
        <div class="title_sec" id="open">
            <h1>{{ $data->judul_video }}</h1>
            <span><i class=" fa fa-user"></i>{{ $nama }}</span>
            <span class="sparator"></span>
            <span><i class="fa fa-calendar-alt"></i>{{ date('d/m/y H:i',strtotime($data->created_at)) }}</span>
        </div>
        {{-- title section --}}
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $data->url_video }}"></iframe>
        </div>
    </div>
</section>
{{-- open_video --}}
{{-- related_video --}}
@if (count($video)>0)
<section id="sec_related_video">
    <div class="container">
        {{-- title section --}}
        <div class="title_sec">
            <h1>Related Video</h1>
        </div>
        {{-- title section --}}
        {{-- Item Owl Carousel --}}
        <div id="related_video_list" class="owl-carousel">
            {{--  item  --}}
            @foreach ($video as $datas)
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
                    <img src="http://img.youtube.com/vi/{{ $data->url_video }}/0.jpg" alt="">
                </div>
                <div class="related_video_desc">
                    <a href="{{ route('home.video.slug',['slug'=>$datas->slug_video]) }}#open">
                        <h1>{{ $datas->judul_video }}</h1>
                    </a>
                    <span><i class="fa fa-user"></i>{{ $namas }}</span>
                    <span class="sparator"></span>
                    <span><i class="fa fa-calendar-alt"></i>{{ date('d/m/y H:i',strtotime($datas->created_at)) }}</span>
                </div>
            </div>
            @endforeach
            {{--  item  --}}
        </div>
        {{-- Item Owl Carousel --}}
    </div>
</section>
@endif
{{-- related_video --}}
@endsection
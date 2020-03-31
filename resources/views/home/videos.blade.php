@extends('layouts.frontend.index')

@push('title')
<title>KATEGORI VIDEO | SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{--  list_video  --}}
<section id="sec_list_video">
    <div class="container" id="tag-videos">
        {{--  title section  --}}
        <div class="title_sec">
            <h1>List Video</h1>
        </div>
        {{--  title section  --}}
        <div id="list_video">
            <div class="row">
                @if (count($video)>0)
                {{--  item  --}}
                @foreach ($video as $data)
                @php
                $publisher = \App\User::where('username' , $data->kode_user)->first();
                if($publisher->role=="Admin System"){
                $nama = "Admin System";
                }else{
                $nama = $publisher->operator->nama_operator;
                }
                @endphp
                <div class="col-md-4 col-sm-12 p-2">
                    <a href="{{ route('home.video.slug',['slug'=>$data->slug_video]) }}#open">
                        <div class="list_video">
                            <div class="thumb_artikel">
                                <img src="http://img.youtube.com/vi/{{ $data->url_video }}/0.jpg" alt="">
                            </div>
                            <div class="list_video_desc">
                                <h1>{{ $data->judul_video }}</h1>
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
                    <h3>Mohon Maaf, Data Video Tidak Ditemukan!</h3>
                </div>
                @endif
            </div>
        </div>
        {{--  Pagination  --}}
        {{ $video->links() }}
        {{--  Pagination  --}}
    </div>
</section>
{{--  list_video  --}}
@endsection
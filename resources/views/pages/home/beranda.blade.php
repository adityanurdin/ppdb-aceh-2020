@extends('layouts.frontend.index')

@push('title')
<title>SIM PPDB Madrasah Kota Banda Aceh</title>
<meta name="description"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh" />
<meta name="keywords"
content="SIM PPDB MADRASAH KOTA BANDA ACEH, Sistem Informasi Manajamen Penerimaan Peserta Didik Baru Madrasah Kota Banda Aceh, SIMPPDB, Madrasah, Kota Banda Aceh, Kemenag Kota Banda Aceh. Madrasah Kota Banca Aceh, Penerimaan Siswa Baru Kota Banda Aceh, PPDB Kota Banda Aceh" />
@endpush

@section('content')
{{--  alur_pendaftaran  --}}
<section id="sec_alur_pendaftaran">
    <div id="pattern_alur">
        <div class="container">
            {{--  title section  --}}
            <div class="title_sec">
                <h1>Alur Pendaftaran SIM PPDB Madrasah</h1>
            </div>
            {{--  title section  --}}
            <div class="row">
                <div class="col-12 text-center">
                    <div class="row">
                        {{--  Item Owl Carousel   --}}
                        <div id="alur_pendaftaran" class="owl-carousel">
                            {{--  1. Mendaftar Akun   --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_1">
                                        <div class="pic_icon">
                                            <i class="fa fa-desktop"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>1. Mendaftar Akun</h1>
                                        <p>
                                            Calon Peserta Didik Mendaftar Akun Secara Online Pada Website SIM PPDB
                                            Madrasah Kota Banda Aceh
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  1. Mendaftar Akun   --}}
                            {{--  2. Melengkapi Data Diri  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_2">
                                        <div class="pic_icon">
                                            <i class="fa fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>2. Melengkapi Data Diri</h1>
                                        <p>
                                            Calon Peserta Didik Melengkapi Data Diri Pada Website SIM PPDB
                                            Madrasah Kota Banda Aceh
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  2. Melengkapi Data Diri  --}}
                            {{--  3. Memilih Madrasah  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_3">
                                        <div class="pic_icon">
                                            <i class="fa fa-building"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>3. Memilih Madrasah</h1>
                                        <p>
                                            Calon Peserta Didik Memilih Madrasah Sesuai Jenjang Yang Diingikan,
                                            Yaitu
                                            MI/MTs/MA.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  3. Memilih Madrasah  --}}
                            {{--  4. Mengunggah File  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_4">
                                        <div class="pic_icon">
                                            <i class="fa fa-file-upload"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>4. Mengunggah File</h1>
                                        <p>
                                            Calon Peserta Didik Mengunggah File Dokumen Sesuai Syarat Masing-Masing
                                            Jenjang Madrasah
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  4. Mengunggah File  --}}
                            {{--  5. Seleksi Dokumen  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_1">
                                        <div class="pic_icon">
                                            <i class="fa fa-file-signature"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>5. Seleksi Dokumen</h1>
                                        <p>
                                            Seleksi Peserta Didik Baru Dilakukan Oleh Masing-Masing Operator
                                            Madrasah
                                            Secara Online
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  5. Seleksi Dokumen  --}}
                            {{--  6. Seleksi Ujian  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_2">
                                        <div class="pic_icon">
                                            <i class="fa fa-user-secret"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>6. Seleksi Ujian</h1>
                                        <p>
                                            Siswa Yang Lolos Seleksi Dokumen, Akan Dilakukan Seleksi Ujian, Untuk
                                            MTs &
                                            MA Terdapat Ujian CAT (Computer Assisted Test)
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  6. Seleksi Ujian  --}}
                            {{--  7. Pengumuman  --}}
                            <div class="col-12 p-2 item">
                                <div class="alur_pendaftaran">
                                    <div class="el_pic_icon bg_3">
                                        <div class="pic_icon">
                                            <i class="fa fa-user-graduate"></i>
                                        </div>
                                    </div>
                                    <div class="alur_pendaftaran_desc">
                                        <h1>7. Pengumuman</h1>
                                        <p>
                                            Siswa Yang Lolos Seleksi Dokumen dan Seleksi Ujian, Akan Diumumkan
                                            Kelulusan
                                            Melalui Artikel SIM PPDB atau Website Madrasah Masing-Masing.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{--  7. Pengumuman  --}}
                            {{--  Item Owl Carousel  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--  alur_pendaftaran  --}}
{{--  list_madrasah  --}}
<section id="sec_list_madrasah">
    <div class="container">
        {{--  title section  --}}
        <div class="title_sec">
            <h1>LIST MADRASAH</h1>
            <p>List Madrasah Yang Terdaftar Ke Dalam SIM PPDB Madrasah Kota Banda Aceh</p>
        </div>
        {{--  title section  --}}
        <div id="pattern_list">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="row">
                        {{--  Item Owl Carousel  --}}
                        <div id="list_madrasah" class="owl-carousel">
                            @foreach ($mdr as $data)
                            <div class="col-12 p-2 item">
                                <div class="list_madrasah">
                                    <div class="list_circle_1">
                                        <div class="list_circle_2">
                                            @if ($data->logo_madrasah=="")
                                                <img src="{{ asset('img/logo-min.png') }}"
                                                    alt="{{ $data->nama_madrasah }}">
                                            @else
                                            <img src="{{ Dits::imageUrl($data->logo_madrasah) }}"
                                                alt="{{ $data->nama_madrasah }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="list_madrasah_desc">
                                        <h1>{{ $data->nama_madrasah }}</h1>
                                        <p>
                                            {{ $data->akreditasi }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{--  Item Owl Carousel  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--  list_madrasah  --}}
@endsection
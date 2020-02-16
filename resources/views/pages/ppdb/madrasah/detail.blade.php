@extends('layouts.backend.index')

@section('css')
    <style>
        .card-header {
            text-align: center;
            background-color: #009DDD;
            color: whitesmoke;
            font-weight: 600;
        }
        .image {
            width: 75%;
        }
        .text {
            color: black;
        }
        .link {
            color: blueviolet;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Data Madrasah
        </div>
        <div class="card-body">
            <div class="row ml-5">
                <div class="col-md-4">
                    <img src="{{Dits::imageUrl($data->logo_madrasah)}}" class="image" alt="">
                </div>
                <div class="col-md-8 mt-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Nama Madrasah </label>
                                </div>
                                <div class="form-group">
                                    <label for="">Akreditasi </label>
                                </div>
                                <div class="form-group">
                                    <label for="">Email </label>
                                </div>
                                <div class="form-group">
                                    <label for="">Kontak </label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    : {{$data->nama_madrasah}}
                                </div>
                                <div class="form-group mt-4">
                                    : {{$data->akreditasi}}
                                </div>
                                <div class="form-group mt-4">
                                    : {{$data->email_madrasah}}
                                </div>
                                <div class="form-group mt-4">
                                    : {{$data->kontak_madrasah}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 ml-5 mt-3">
                    <div class="form-group">
                        Kode Satker
                    </div>
                    <div class="form-group">
                        NSM
                    </div>
                    <div class="form-group">
                        NPSN
                    </div>
                    <div class="form-group">
                        Status
                    </div>
                    <div class="form-group">
                        Jenjang
                    </div>
                    <div class="form-group">
                        Alamat
                    </div>
                    <div class="form-group">
                        Kelurahan/Desa
                    </div>
                    <div class="form-group">
                        Kecamatan
                    </div>
                    <div class="form-group">
                        Kabupaten
                    </div>
                    <div class="form-group">
                        Provinsi
                    </div>
                    <div class="form-group">
                        Brosur
                    </div>
                    <div class="form-group">
                        Preview Madrasah
                    </div>
                </div>
                <div class="col-md-8 mt-3">
                    <div class="form-group">
                        : {{$data->kode_satker}}
                    </div>
                    <div class="form-group">
                        : {{$data->nsm}}
                    </div>
                    <div class="form-group">
                        : {{$data->npsn}}
                    </div>
                    <div class="form-group">
                        : {{$data->status}}
                    </div>
                    <div class="form-group">
                        : {{$data->jenjang}}
                    </div>
                    <div class="form-group">
                        : {{$data->alamat}}
                    </div>
                    <div class="form-group">
                        : {{$data->kelurahan}}
                    </div>
                    <div class="form-group">
                        : {{$data->kecamatan}}
                    </div>
                    <div class="form-group">
                        : {{$data->kabupaten}}
                    </div>
                    <div class="form-group">
                        : {{$data->provinsi}}
                    </div>
                    <div class="form-group">
                        : <a href="{{Dits::PdfViewer(asset($data->pembukaan['url_brosur']))}}" class="link" target="_blank">Lihat Brosur</a>
                    </div>
                    <div class="form-group">
                        : {{ $data->preview }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @isset($pendaftaran)
        <div class="card mt-5">
            <div class="card-header">
                Data Pendaftaran
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            Kode Pendaftaran
                        </div>
                        <div class="form-group">
                            Tanggal Pembukaan
                        </div>
                        <div class="form-group">
                            Tanggal Penutupan
                        </div>
                        <div class="form-group">
                            Tanggal Pengumuman
                        </div>
                        <div class="form-group">
                            Tanggal Pendaftaran
                        </div>
                        <div class="form-group">
                            Status Pendaftaran
                        </div>
                        <div class="form-group">
                            Status Penerimaan
                        </div>
                        <div class="form-group">
                            Jalur Penerimaan
                        </div>
                        <div class="form-group">
                            Bukti Transfer Daftar Ulang
                        </div>
                        <div class="form-group">
                            Status Bukti Transfer
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group text-danger">
                            : {{$pendaftaran->kode_pendaftaran}}
                        </div>
                        <div class="form-group">
                            : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pembukaan'])->toFormattedDateString() }}
                        </div>
                        <div class="form-group">
                            : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_penutupan'])->toFormattedDateString() }}
                        </div>
                        <div class="form-group">
                            : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pengumuman'])->toFormattedDateString() }}
                        </div>
                        <div class="form-group">
                            : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pendaftaran->tgl_pendaftaran)->toFormattedDateString() }}
                        </div>
                        <div class="form-group">
                            : {{$pendaftaran->status_pendaftaran}}
                        </div>
                        <div class="form-group">
                            : {{$pendaftaran->status_diterima}}
                        </div>
                        <div class="form-group">
                            : {{$pendaftaran->jalur_diterima}}
                        </div>
                        <div class="form-group">
                            @if ($pendaftaran->url_transfer == '')
                            : -
                            @else 
                            : <a href="{{Dits::PdfViewer(asset($pendaftaran->url_transfer))}}" class="link" target="_blank">Lihat Bukti Transfer</a>
                            @endif
                        </div>
                        <div class="form-group">
                            : {{$pendaftaran->status_transfer}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
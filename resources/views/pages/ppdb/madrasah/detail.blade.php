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
            width: 225px;
            height: 225px;
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

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Detail Madrasah</a></li>
        <li class="bc-item active" aria-current="page">{{$data->nama_madrasah}}</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Data Madrasah
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col col-auto mx-auto">
                  <img src="{{Dits::imageUrl($data->logo_madrasah)}}" class="image rounded">
                </div>
                <div class="col mt-1">
                  <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <p><strong>{{$data->nama_madrasah}}</strong></p>
                              <table>
                                <tr>
                                  <td><strong>Jenjang</strong></td>
                                  <td>:</td>
                                  <td>{{$data->jenjang}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Status</strong></td>
                                  <td>:</td>
                                  <td>{{$data->status}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Kecamatan</strong></td>
                                  <td>:</td>
                                  <td>{{$data->kecamatan}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Akreditasi</strong></td>
                                  <td>:</td>
                                  <td>{{$data->akreditasi}}</td>
                                </tr>
                              </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row mt-3">
                  <div class="col">
                    <div class="card shadow">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                <tr>
                                  <td><strong>Kode Satker</strong></td>
                                  <td>:</td>
                                  <td>{{$data->kode_satker}}</td>
                                </tr>
                                <tr>
                                  <td><strong>NSM</strong></td>
                                  <td>:</td>
                                  <td>{{$data->nsm}}</td>
                                </tr>
                                <tr>
                                  <td><strong>NPSN</strong></td>
                                  <td>:</td>
                                  <td>{{$data->npsn}}</td>
                                </tr>
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col">
                    <div class="card shadow">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                <tr>
                                  <td><strong>Alamat</strong></td>
                                  <td>:</td>
                                  <td>{{$data->alamat}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Kelurahan</strong></td>
                                  <td>:</td>
                                  <td>{{$data->kelurahan}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Kabupaten</strong></td>
                                  <td>:</td>
                                  <td>{{$data->kabupaten}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Provinsi</strong></td>
                                  <td>:</td>
                                  <td>{{$data->provinsi}}</td>
                                </tr>
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col">
                    <div class="card shadow">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                <tr>
                                  <td><strong>Alamat Email</strong></td>
                                  <td>:</td>
                                  <td>{{$data->email_madrasah}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Kontak/Tlp</strong></td>
                                  <td>:</td>
                                  <td>{{$data->kontak_madrasah}}</td>
                                </tr>
                                <tr>
                                  <td><strong>Brosur</strong></td>
                                  <td>:</td>
                                  <td><a href="{{Dits::PdfViewer(asset($data->pembukaan['url_brosur']))}}" target="_blank" class="btn btn-block btn-info"><i class="fas fa-file-image"></i> Brosur</a></td>
                                </tr>
                                <tr>
                                  <td><strong>Preview Madrasah</strong></td>
                                  <td>:</td>
                                  <td>{{ $data->preview }}</td>
                                </tr>
                              </table>
                          </div>
                      </div>
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
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Kode Pendaftaran</td>
                            <td>:</td>
                            <td class="text-danger">{{$pendaftaran->kode_pendaftaran}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pembukaan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pembukaan'])->toFormattedDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Penutupan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_penutupan'])->toFormattedDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengumuman</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pengumuman'])->toFormattedDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pendaftaran->tgl_pendaftaran)->toFormattedDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Status Pendaftaran</td>
                            <td>:</td>
                            <td>{{$pendaftaran->status_pendaftaran}}</td>
                        </tr>
                        <tr>
                            <td>Status Penerimaan</td>
                            <td>:</td>
                            <td>{{$pendaftaran->status_diterima}}</td>
                        </tr>
                        <tr>
                            <td>Jalur Penerimaan</td>
                            <td>:</td>
                            <td>{{$pendaftaran->jalur_diterima}}</td>
                        </tr>
                        <tr>
                            <td>Bukti Transfer Daftar Ulang</td>
                            <td>:</td>
                            <td>
                                @if ($pendaftaran->url_transfer == '')
                            -
                            @else 
                            <a href="{{Dits::PdfViewer(asset($pendaftaran->url_transfer))}}" class="link" target="_blank">Lihat Bukti Transfer</a>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Status Bukti Transfer</td>
                            <td>:</td>
                            <td>{{$pendaftaran->status_transfer}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endisset
@endsection
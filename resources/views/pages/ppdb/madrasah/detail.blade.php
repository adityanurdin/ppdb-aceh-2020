@extends('layouts.backend.index')

@section('css')
<style>
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
  <div class="card-header bg-dark text-white text-left">
    <h5><i class="fa fa-building"></i> Data Madrasah</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col col-auto mx-auto">
        <img src="{{Dits::imageUrl($data->logo_madrasah)}}" class="image rounded">
      </div>
      <div class="col mt-3">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <h5 class="text-dark text-center text-uppercase">{{$data->nama_madrasah}}</h5>
              <hr>
              <table>
                <tr>
                  <th width="120px;">Jenjang</th>
                  <td width="10px;">:</td>
                  <td>{{$data->jenjang}}</td>
                </tr>
                <tr>
                  <th width="120px;">Status</th>
                  <td width="10px;">:</td>
                  <td>{{$data->status}}</td>
                </tr>
                <tr>
                  <th width="120px;">Kecamatan</th>
                  <td width="10px;">:</td>
                  <td>{{$data->kecamatan}}</td>
                </tr>
                <tr>
                  <th width="120px;">Akreditasi</th>
                  <td width="10px;">:</td>
                  <td>{{$data->akreditasi}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="py-3 mt-5">
      <table class="table">
        <tr>
          <th width="200px;">Kode Satker</th>
          <td>:</td>
          <td>{{$data->kode_satker}}</td>
        </tr>
        <tr>
          <th>NSM</th>
          <td>:</td>
          <td>{{$data->nsm}}</td>
        </tr>
        <tr>
          <th>NPSN</th>
          <td>:</td>
          <td>{{$data->npsn}}</td>
        </tr>
        <tr>
          <th>Alamat</th>
          <td>:</td>
          <td>{{$data->alamat}}</td>
        </tr>
        <tr>
          <th>Kelurahan</th>
          <td>:</td>
          <td>{{$data->kelurahan}}</td>
        </tr>
        <tr>
          <th>Kabupaten</th>
          <td>:</td>
          <td>{{$data->kabupaten}}</td>
        </tr>
        <tr>
          <th>Provinsi</th>
          <td>:</td>
          <td>{{$data->provinsi}}</td>
        </tr>
        <tr>
          <th>Alamat Email</th>
          <td>:</td>
          <td>{{$data->email_madrasah}}</td>
        </tr>
        <tr>
          <th>Kontak/Tlp</th>
          <td>:</td>
          <td>{{$data->kontak_madrasah}}</td>
        </tr>
        <tr>
          <th>Brosur</th>
          <td>:</td>
          <td><a href="{{Dits::PdfViewer(asset($data->pembukaan['url_brosur']))}}" target="_blank"
              class="btn btn-block btn-info"><i class="fas fa-file-image"></i> Brosur</a></td>
        </tr>
        <tr>
          <th>Preview Madrasah</th>
          <td width="10px;">:</td>
          <td>{{ $data->preview }}</td>
        </tr>
      </table>
    </div>
  </div>
</div>

@isset($pendaftaran)
<div class="card mt-3">
  <div class="card-header bg-dark text-white text-left">
    <h5><i class="fa fa-desktop"></i> Data Pendaftaran</h5>
  </div>
  <div class="card-body">
    <div class="mt-3">
      <table class="table">
        <tr>
          <th width="200px;">Kode Pendaftaran</th>
          <td>:</td>
          <td class="text-danger">
            <b>{{$pendaftaran->kode_pendaftaran}}</b>
          </td>
        </tr>
        <tr>
          <th>Tanggal Pembukaan</th>
          <td>:</td>
          <td>
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pembukaan'])->toFormattedDateString() }}
          </td>
        </tr>
        <tr>
          <th>Tanggal Penutupan</th>
          <td>:</td>
          <td>
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_penutupan'])->toFormattedDateString() }}
          </td>
        </tr>
        <tr>
          <th>Tanggal Pengumuman</th>
          <td>:</td>
          <td>
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $pendaftaran->pembukaan['tgl_pengumuman'])->toFormattedDateString() }}
          </td>
        </tr>
        <tr>
          <th>Tanggal Pendaftaran</th>
          <td>:</td>
          <td>
            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pendaftaran->tgl_pendaftaran)->toFormattedDateString() }}
          </td>
        </tr>
        <tr>
          <th>Status Pendaftaran</th>
          <td>:</td>
          <td>{{$pendaftaran->status_pendaftaran}}</td>
        </tr>
        <tr>
          <th>Status Penerimaan</th>
          <td>:</td>
          <td>{{$pendaftaran->status_diterima}}</td>
        </tr>
        <tr>
          <th>Jalur Penerimaan</th>
          <td>:</td>
          <td>{{$pendaftaran->jalur_diterima}}</td>
        </tr>
        <tr>
          <th>Bukti Transfer Daftar Ulang</th>
          <td>:</td>
          <td>
            @if ($pendaftaran->url_transfer == '')
            -
            @else
            <a href="{{Dits::PdfViewer(asset($pendaftaran->url_transfer))}}" class="link" target="_blank">Lihat Bukti
              Transfer</a>
            @endif
          </td>
        </tr>
        <tr>
          <th>Status Bukti Transfer</th>
          <td width="10px;">:</td>
          <td>{{$pendaftaran->status_transfer}}</td>
        </tr>
      </table>
    </div>
  </div>
</div>
@endisset
@endsection
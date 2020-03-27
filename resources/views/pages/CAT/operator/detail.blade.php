@extends('layouts.backend.index')

@section('css')
<style>
    .card-header {
        text-align: center;
        background-color: #11AFF0;
        color: whitesmoke;
        font-weight: 700;
    }

    .btn_detail a {
        margin-bottom: 5px;
    }

    @media screen and (max-width: 767.98px) {
        .btn_detail a {
            width: 100%;
            display: block;
            margin-bottom: 10px;
        }
    }
</style>
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Bank Soal</li>
        <li class="bc-item" aria-current="page">Detail</li>
        <li class="bc-item active" aria-current="page">{{$data->madrasah['nama_madrasah']}}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="text-center mb-4">Data Bank Soal</h4>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th width="200px">Nama Madrasah</th>
                        <th width="10px">:</th>
                        <td>{{$data->madrasah['nama_madrasah']}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Kode Soal</th>
                        <th width="10px">:</th>
                        <td>{{$data->kode_soal}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Tanggal Soal</th>
                        <th width="10px">:</th>
                        <td>{{$data->tgl_bank_soal}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Status Soal</th>
                        <th width="10px">:</th>
                        <td>{{$data->status_bank_soal}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Status Crash CAT</th>
                        <th width="10px">:</th>
                        <td>{{$data->crash_session}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Waktu CAT</th>
                        <th width="10px">:</th>
                        <td>{{$data->timer_cat}} Menit <a href="#" data-toggle="modal" data-target="#updateTimer"
                                style="font-size: 15px; margin-left: 8px;"><i class="fas fa-edit"></i> Ubah</a></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="py-3 btn_detail text-center">
            <a href="{{route('bank-soal.tulis-soal' , Dits::encodeDits($data->uuid))}}" class="btn btn-info btn-sm"><i
                    class="fas fa-pen-square"></i> Tulis Soal</a>
            <a href="#" data-toggle="modal" data-target="#uploadSoal" class="btn btn-info btn-sm"><i
                    class="fas fa-upload"></i> Upload Soal</a>
            <a href="{{route('bank-soal.status-bank' , Dits::encodeDits($data->uuid))}}"
                class="btn btn-warning btn-sm"><i class="fas fa-power-off"></i> Ubah Bank Status</a>
            <a href="{{route('bank-soal.hapus-bank' , Dits::encodeDits($data->uuid))}}" class="btn btn-danger btn-sm"><i
                    class="fas fa-trash"></i> Hapus Bank Soal</a>
            <a href="{{route('export.peserta-ujian' , $data->kode_soal)}}" class="btn btn-success btn-sm"><i
                    class="fas fa-file-excel"></i> Export Peserta CAT</a>
            <a href="" data-toggle="modal" data-target="#importJawaban" class="btn btn-info btn-sm"><i class="fas fa-cloud-upload-alt"></i> Import Jawaban CAT</a>
            <a href="{{route('bank-soal.crash' , Dits::encodeDits($data->uuid))}}" class="btn btn-danger btn-sm"><i
                    class="fas fa-user-slash"></i> Crash CAT</a>
        </div>

    </div>
</div>

<div class="card mt-5 shadow rounded">
    <div class="card-header text-white bg-secondary">
        <h4 class="text-center"><i class="fa fa-list-ol"></i> Daftar Soal</h4>
    </div>
    <div class="card-body text-dark bg-white">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover" id="daftar-soal">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Kode Soal</th>
                        <th>Jenis Soal</th>
                        <th width="50%">Soal</th>
                        <th width="150px">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-5 shadow rounded">
    <div class="card-header text-white bg-success">
        <h4 class="text-center"><i class="fa fa-desktop"></i> Peserta Ujian</h4>
    </div>
    <div class="card-body text-dark bg-white">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="table-peserta">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Kode Soal</th>
                        <th>Kode Pendaftaran</th>
                        <th>Nama Peserta</th>
                        <th>Jawaban Benar</th>
                        <th>Jawaban Salah</th>
                        <th>Tidak Terjawab</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modal')
{{-- Modal --}}
<div class="modal fade" id="uploadSoal" tabindex="-1" role="dialog" aria-labelledby="uploadSoalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadSoalLabel">Upload Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('import.soal')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Upload</label>
                        <input type="file" name="file_import" class="form-control">
                        <input type="hidden" name="kode_soal" value="{{$data->kode_soal}}" id="">
                        <small>File : .CSV (MS-Dos/Comma Delimited) | Ukuran Maksimal : 1000KB/1MB</small>
                    </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('download.file' , ['Documents' , 'format_upload_soal_cat.xlsx'])}}"
                    class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Soal</a>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import jawaban -->
<div class="modal fade" id="importJawaban" tabindex="-1" role="dialog" aria-labelledby="importJawabanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importJawabanLabel">Import Jawaban</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('import.jawaban')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
              <div class="form-group">
                  <label for="">File Import Jawaban</label>
                  <input type="file" name="file_upload" id="" class="form-control">
                  <small style="color: red;">File harus berformat CSV | Max 300kb</small>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Import</button>
            </div>

        </form>
      </div>
    </div>
  </div>

{{-- Modal update timer --}}
<div class="modal fade" id="updateTimer" tabindex="-1" role="dialog" aria-labelledby="updateTimerLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTimerLabel">Ubah Waktu CAT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('bank-soal.update-timer' , Dits::encodeDits($data->uuid))}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Waktu CAT</label>
                        <input type="number" name="timer_cat" class="form-control">
                        <label for="">Dalam Menit</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<input type="hidden" value="{{$data->kode_soal}}" id="params">
<script>
    $(function() {
        $('#table-peserta').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('bank-soal.detail-data',['id'=>Dits::encodeDits($data->kode_soal)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_soal', name: 'kode_soal'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'nama_peserta', name: 'nama_peserta'},
                {data: 'jawaban_benar', name: 'jawaban_benar'},
                {data: 'jawaban_salah', name: 'jawaban_salah'},
                {data: 'tidak_jawab', name: 'tidak_jawab'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,2,4,5,6] },
              { className: "min_action text-center", "targets": [7] }
            ],
        });

        $('#daftar-soal').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('bank-soal.soal-data',['id'=>Dits::encodeDits($data->kode_soal)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_soal', name: 'kode_soal'},
                {data: 'jenis_soal', name: 'jenis_soal'},
                {data: 'soal', name: 'soal'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,2] },
              { className: "min_action text-center", "targets": [4] }
            ],
        })
    });
</script>
@endpush
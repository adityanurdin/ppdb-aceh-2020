@extends('layouts.backend.index')

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <style>
        .card-header {
            text-align: center;
            background-color: #11AFF0;
            color: whitesmoke;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Data Bank Soal
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <h6>Nama Madrasah</h6>
                        <h6>Kode Soal</h6>
                        <h6>Tanggal Soal</h6>
                        <h6>Status Soal</h6>
                        <h6>Status Crash CAT</h6>
                        <h6>Waktu CAT</h6>
                    </div>
                    <div class="col-md-10">
                        <h6>: {{$data->madrasah['nama_madrasah']}}</h6>
                        <h6>: {{$data->kode_soal}}</h6>
                        <h6>: {{$data->tgl_bank_soal}}</h6>
                        <h6>: {{$data->status_bank_soal}}</h6>
                        <h6>: {{$data->crash_session}}</h6>
                        <h6>: {{$data->timer_cat}} Menit <a href="#" data-toggle="modal" data-target="#updateTimer" style="font-size: 15px; margin-left: 8px;"><i class="fas fa-edit"></i> Ubah</a></h6>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{route('bank-soal.tulis-soal' , Dits::encodeDits($data->uuid))}}" class="btn btn-info btn-sm"><i class="fas fa-pen-square"></i> Tulis Soal</a>
                    <a href="#" data-toggle="modal" data-target="#uploadSoal" class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload Soal</a>
                    <a href="{{route('bank-soal.status-bank' , Dits::encodeDits($data->uuid))}}" class="btn btn-warning btn-sm"><i class="fas fa-power-off"></i> Ubah Bank Status</a>
                    <a href="{{route('bank-soal.hapus-bank' , Dits::encodeDits($data->uuid))}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus Bank Soal</a>
                    <a href="#" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Peserta CAT</a>
                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-cloud-upload-alt"></i> Import Jawaban CAT</a>
                    <a href="{{route('bank-soal.crash' , Dits::encodeDits($data->uuid))}}" class="btn btn-danger btn-sm"><i class="fas fa-user-slash"></i> Crash CAT</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Daftar Soal
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover" id="daftar-soal">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Soal</th>
                        <th>Jenis Soal</th>
                        <th>Soal</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Peserta Ujian
        </div>
        <div class="card-body">
            <div class="container mt-2 mb-2">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="table-peserta">
                        <thead>
                            <tr>
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
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="uploadSoal" tabindex="-1" role="dialog" aria-labelledby="uploadSoalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="uploadSoalLabel">Upload Soal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="#">
                <div class="form-group">
                    <label for="">Upload</label>
                    <input type="file" name="upload_soal" class="form-control">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <a href="{{route('download.file' , ['Documents' , 'format_upload_soal_cat.xlsx'])}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Soal</a>
            <button type="button" class="btn btn-primary btn-sm">Upload</button>
            </div>
        </div>
        </div>
    </div>
    
    <!-- Modal update timer -->
    <div class="modal fade" id="updateTimer" tabindex="-1" role="dialog" aria-labelledby="updateTimerLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="updateTimerLabel">Ubah Waktu CAT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{route('bank-soal.update-timer' , Dits::encodeDits($data->uuid))}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Waktu CAT</label>
                    <input type="number" name="timer_cat" class="form-control">
                    <label for="">Dalam Menit</label>
                </div>
            </div>
            <div class="modal-footer">
            {{-- <a href="{{route('download.file' , ['Documents' , 'format_upload_soal_cat.xlsx'])}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Soal</a> --}}
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var token = $('#params').val();

            $('#table-peserta').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/CAT/Bank/Soal/detail-data/"+token,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_soal', name: 'kode_soal'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'nama_peserta', name: 'nama_peserta'},
                    {data: 'jawaban_benar', name: 'jawaban_benar'},
                    {data: 'jawaban_salah', name: 'jawaban_salah'},
                    {data: 'tidak_jawab', name: 'tidak_jawab'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#daftar-soal').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/CAT/Bank/Soal/soal-data/"+token,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_soal', name: 'kode_soal'},
                    {data: 'jenis_soal', name: 'jenis_soal'},
                    {data: 'soal', name: 'soal'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            })


            });
    </script>
@endpush
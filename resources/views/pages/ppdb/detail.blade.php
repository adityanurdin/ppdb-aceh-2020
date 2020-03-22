@extends('layouts.backend.index')

@section('css')
<style>
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
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Buka PPDB</a></li>
        <li class="bc-item" aria-current="page">Detail</li>
        <li class="bc-item active" aria-current="page">{{$data->madrasah['nama_madrasah']}}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="text-center mb-4">{{$data->madrasah['nama_madrasah']}}</h4>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th width="200px">Tanggal Pembukaan</th>
                        <th width="10px">:</th>
                        <td>{{$data->tgl_pembukaan}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Tanggal Penutupan</th>
                        <th width="10px">:</th>
                        <td>{{$data->tgl_penutupan}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Tanggal Pengumuman</th>
                        <th width="10px">:</th>
                        <td>{{$data->tgl_pengumuman}}</td>
                    </tr>
                    <tr>
                        <th width="200px">Status Pembukaan</th>
                        <th width="10px">:</th>
                        <td>{{$data->status_pembukaan}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="py-3 btn_detail text-center">
            <a href="{{Dits::PdfViewer(asset($data->url_brosur))}}" target="_blank" class="btn btn-danger btn-sm"><i
                    class="fas fa-file-pdf"></i> Lihat Brosur</a>
            <a href="{{route('buka-ppdb.rubah-status' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-info"><i
                    class="fas fa-pen-square"></i> Ubah Status</a>
            <a href="{{route('buka-ppdb.edit' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-warning"><i
                    class="fas fa-pen-square"></i> Edit Pembukaan</a>
            <a href="{{route('buka-ppdb.dokumen-persyaratan' , Dits::encodeDits($data->uuid))}}"
                class="btn btn-sm btn-dark"><i class="fas fa-link"></i> Dokumen Persyaratan</a>
            <a href="{{route('buka-ppdb.delete' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-danger"
                onclick="return confirm('Anda Yakin Untuk Hapus Data Ini?');"><i class="fas fa-pen-square"></i> Hapus
                Pembukaan</a>
            <a href="#" data-toggle="modal" data-target="#addPeserta" class="btn btn-sm btn-info"><i
                    class="fas fa-user-plus"></i> Jalur Khusus</a>
            <a href="{{route('export.pendaftaran' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-success"><i
                    class="fas fa-file-excel"></i> Export Data</a>
        </div>

    </div>
</div>

{{-- Verifikasi PPDB Madrasah --}}
<div class="card mt-5 shadow rounded">
    <div class="card-header text-white bg-secondary">
        <h4 class="text-center"><i class="fa fa-check-circle"></i> Verifikasi PPDB Madrasah</h4>
    </div>

    <div class="card-body text-dark bg-white">
        <div class="py-3">
            <h6 class="text-warning">Jumlah Pendaftar Belum Terverifikasi :
                {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Baru')}}
            </h6>
            <h6 class="text-success">Jumlah Peserta Lolos Tahap Dokumen :
                {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Lolos Tahap Dokumen')}}
            </h6>
            <h6 class="text-danger">Jumlah Peserta Tidak Lolos Tahap Dokumen :
                {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Tidak Lolos Tahap Dokumen')}}
            </h6>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="dataVerifikasi">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Kode Pendaftaran</th>
                        <th>Nama Peserta</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th width="135">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Verifikasi PPDB Madrasah --}}

{{-- Data Peserta Pendaftaran --}}
<div class="card mt-5 shadow rounded">
    <div class="card-header text-white bg-info">
        <h4 class="text-center"><i class="fa fa-user-tag"></i> Data Peserta Pendaftaran</h4>
    </div>

    <div class="card-body text-dark bg-white">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover mt-5" id="dataPendaftaran">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Kode Pendaftaran</th>
                        <th>Nama Peserta</th>
                        <th>Alamat</th>
                        <th>Status Pendaftaran</th>
                        <th>Status Diterima</th>
                        <th width="135">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Data Peserta Pendaftaran --}}

{{-- Pengumuman Seleksi --}}
<div class="card mt-5 shadow rounded">
    <div class="card-header text-white bg-success">
        <h4 class="text-center"><i class="fa fa-user-check"></i> Pengumuman Seleksi</h4>
    </div>

    <div class="card-body text-dark bg-white">
        <div class="py-3 btn_detail">
            <a href="{{route('buka-ppdb.pengumuman' , Dits::encodeDits($data->uuid))}}"
                class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Pengumuman</a>
            <a href="{{route('import.pengumuman.view' , Dits::encodeDits($data->uuid))}}"
                class="btn btn-success btn-sm"><i class="fas fa-upload"></i> Upload Pengumuman</a>
            <a href="{{route('download.file' , ['Documents' , 'format_pengumuman.xlsx'])}}"
                class="btn btn-success btn-sm"><i class="fas fa-download"></i> Format Pengumuman</a>
        </div>

        <div class="card mt-2">
            <div class="card-header text-white bg-success">
                <h6 class="text-left"><i class="fa fa-user-check"></i> Data Peserta Diterima</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-hover mt-5" id="dataDiterima">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Kode Pendaftaran</th>
                                <th>Nama Peserta</th>
                                <th>Alamat</th>
                                <th>Status Diterima</th>
                                <th>Jalur Diterima</th>
                                <th width="135">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header text-white bg-danger">
                <h6 class="text-left"><i class="fa fa-user-times"></i> Data Peserta Ditolak</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-hover mt-5" id="dataDitolak">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Kode Pendaftaran</th>
                                <th>Nama Peserta</th>
                                <th>Alamat</th>
                                <th>Status Diterima</th>
                                <th>Jalur Diterima</th>
                                <th width="135">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Pengumuman Seleksi --}}

{{-- Data Peserta Daftar Ulang --}}
<div class="card mt-5 shadow rounded">
    <div class="card-header text-dark bg-light">
        <h4 class="text-center"><i class="fa fa-list-ol"></i> Data Peserta Daftar Ulang</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover mt-5" id="daftar-ulang">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Peserta</th>
                        <th>File Transfer</th>
                        <th>Status Transfer</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Data Peserta Daftar Ulang --}}
@endsection

@push('script')
<script>
    $(function() {

        $('#dataPendaftaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-peserta',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'peserta.nama', name: 'peserta.nama'},
                {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                {data: 'status_pendaftaran', name: 'status_pendaftaran'},
                {data: 'status_diterima', name: 'status_diterima'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,4,5] },
              { className: "min_action text-center", "targets": [6] }
            ],
        });
        
        $('#dataVerifikasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-verifikasi',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'peserta.nama', name: 'peserta.nama'},
                {data: 'peserta.jkl', name: 'peserta.jkl'},
                {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1] },
              { className: "min_action text-center", "targets": [5] }
            ],
        });
        
        $('#dataDiterima').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-diterima',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'peserta.nama', name: 'peserta.nama'},
                {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                {data: 'status_diterima', name: 'status_diterima'},
                {data: 'jalur_diterima', name: 'jalur_diterima'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,4,5] },
              { className: "min_action text-center", "targets": [6] }
            ],
        });
        
        $('#dataDitolak').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-ditolak',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'peserta.nama', name: 'peserta.nama'},
                {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                {data: 'status_diterima', name: 'status_diterima'},
                {data: 'jalur_diterima', name: 'jalur_diterima'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,4,5] },
              { className: "min_action text-center", "targets": [6] }
            ],
        });
        
        $('#daftar-ulang').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-daftar-ulang',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'peserta.nama', name: 'peserta.nama'},
                {data: 'file_transfer', name: 'file_transfer'},
                {data: 'status_transfer', name: 'status_transfer'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,4] },
              { className: "min_action text-center", "targets": [5] }
            ],
        });

    });
</script>
@endpush

@section('modal')

@foreach ($pendaftaran as $item)
{{-- Modal --}}
<div class="modal fade" id="opsi-{{$item->uuid}}" tabindex="-1" role="dialog"
    aria-labelledby="opsi-{{$item->uuid}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="opsi-{{$item->uuid}}Label">{{$item->peserta['nama']}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('buka-ppdb.update.daftar.ulang' , Dits::encodeDits($item->uuid))}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Status Daftar Ulang</label>
                        <select class="form-control" name="status_transfer" id="exampleFormControlSelect1">
                            <option selected disabled>-Pilih Status</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Pembayaran Kurang">Pembayaran Kurang</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="sumbit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Modal --}}
<div class="modal fade" id="addPeserta" tabindex="-1" role="dialog" aria-labelledby="addPesertaLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-info text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addPesertaLabel"><i class="fa fa-user-plus"></i> Jalur Khusus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white text-dark">
                <form action="{{route('import.jalur-khusus' , $data->uuid)}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Upload *</label>
                        <input type="file" name="file_import" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('download.file' , ['Documents' , 'format_jalur_khusus.xlsx'])}}"
                    class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Jalur Khusus</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
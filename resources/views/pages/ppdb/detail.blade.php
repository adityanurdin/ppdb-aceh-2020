@extends('layouts.backend.index')


@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="text-center">{{$data->madrasah['nama_madrasah']}}</h4>
            <div class="row mt-5 ml-5">
                <div class="col-md-4">
                    <p class="text-dark">Tanggal Pembukaan</p>
                    <p class="text-dark">Tanggal Penutupan</p>
                    <p class="text-dark">Tanggal Pengumuman</p>
                    <p class="text-dark">Status Pembukaan</p>
                </div>
                <div class="col-md-8">
                    <p class="text-dark">: {{$data->tgl_pembukaan}}</p>
                    <p class="text-dark">: {{$data->tgl_penutupan}}</p>
                    <p class="text-dark">: {{$data->tgl_pengumuman}}</p>
                    <p class="text-dark">: {{$data->status_pembukaan}}</p>
                </div>
            </div>
            <div class="container mt-5 text-center">
                <a href="{{Dits::PdfViewer(asset($data->url_brosur))}}" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Lihat Brosur</a>
                <a href="{{route('buka-ppdb.rubah-status' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-info"><i class="fas fa-pen-square"></i> Ubah Status</a>
                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-pen-square"></i> Edit Pembukaan</a>
                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-pen-square"></i> Hapus Pembukaan</a>
                <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Data</a>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <h6 class="text-center">Data Peserta Pendaftaran</h6>

            <table class="table table-borderless table-hover mt-5" id="myTable">
                <thead>
                    <tr>
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

    <div class="card mt-5">
        <div class="card-body">
            
            <h5 class="text-center">Pengumuman Seleksi</h5>

            <a href="#" class="btn btn-info mt-5 btn-sm"><i class="fas fa-plus"></i> Tambah Pengumuman</a>
            <a href="#" class="btn btn-info mt-5 btn-sm"><i class="fas fa-upload"></i> Upload Pengumuman</a>
            <a href="#" class="btn btn-info mt-5 btn-sm"><i class="fas fa-download"></i> Format Pengumuman</a>

            <div class="card mt-2">
                <div class="card-body">
                    <h6 class="text-center">Data Peserta Diterima</h6>
        
                    <table class="table table-borderless table-hover mt-5" id="myTable2">
                        <thead>
                            <tr>
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
            
            <div class="card mt-5">
                <div class="card-body">
                    <h6 class="text-center">Data Peserta Ditolak</h6>
        
                    <table class="table table-borderless table-hover mt-5" id="myTable3">
                        <thead>
                            <tr>
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
    </div>
    
    <div class="card mt-5">
        <div class="card-body">
            
            <h5 class="text-center">Daftar Ulang</h5>

            <div class="card mt-2">
                <div class="card-body">
                    <h6 class="text-center">Daftar Peserta Sudah Upload Daftar Ulang</h6>
        
                <a href="#" class="btn btn-info mt-5 mb-3 btn-sm"><i class="fas fa-file-excel"></i> Export Sudah Transfer</a>
                    <table class="table table-borderless table-hover mt-5" id="myTable4">
                        <thead>
                            <tr>
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
            
            <div class="card mt-5">
                <div class="card-body">
                    <h6 class="text-center">Daftar Peserta Belum Upload Daftar Ulang</h6>
                    
                <a href="#" class="btn btn-info mt-5 mb-3 btn-sm"><i class="fas fa-file-excel"></i> Export Belum Transfer</a>

        
                    <table class="table table-borderless table-hover mt-5" id="myTable5">
                        <thead>
                            <tr>
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
    </div>
    
    


@endsection

@push('script')
<input type="hidden" id="params" value="{{Dits::encodeDits($data->uuid)}}">

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var token = $('#params').val();
            
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#myTable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#myTable3').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#myTable4').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#myTable5').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush
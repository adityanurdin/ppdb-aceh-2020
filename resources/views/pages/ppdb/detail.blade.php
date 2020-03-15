@extends('layouts.backend.index')

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

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            {{-- <div class="table-responsive"> --}}
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
                    <a href="{{route('buka-ppdb.edit' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-warning"><i class="fas fa-pen-square"></i> Edit Pembukaan</a>
                    <a href="{{route('buka-ppdb.dokumen-persyaratan' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-dark"><i class="fas fa-link"></i> Dokumen Persyaratan</a>
                    <a href="{{route('buka-ppdb.delete' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-danger"><i class="fas fa-pen-square"></i> Hapus Pembukaan</a>
                    <a href="#" data-toggle="modal" data-target="#addPeserta" class="btn btn-sm btn-info"><i class="fas fa-user-plus"></i> Jalur Khusus</a>
                    <a href="{{route('export.pendaftaran' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Data</a>
                </div>
            {{-- </div> --}}

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">

            <h6 class="text-center">Verifikasi PPDB Madrasah</h6>

            <div class="mt-5 mb-3">
                <h6>Jumlah Pendaftar Belum Terverifikasi : {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Baru')}}</h6>
                <h6>Jumlah Peserta Lolos Tahap Dokumen : {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Lolos Tahap Dokumen')}}</h6>
                <h6>Jumlah Peserta Tidak Lolos Tahap Dokumen : {{Dits::countTableByWhere('App\Models\Pendaftaran' , 'uuid_pembukaan' , $data->uuid , 'status_pendaftaran' , 'Tidak Lolos Tahap Dokumen')}}</h6>
            </div>
            <div class="table-responsive">
    
    
                <table class="table table-borderless table-hover" id="dataVerifikasi">
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

    <div class="card mt-5">
        <div class="card-body">
            <h6 class="text-center">Data Peserta Pendaftaran</h6>

            <div class="table-responsive">
                <table class="table table-borderless table-hover mt-5" id="dataPendaftaran">
                    <thead>
                        <tr>
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

    <div class="card mt-5">
        <div class="card-body">
            
            <h5 class="text-center">Pengumuman Seleksi</h5>

            <a href="{{route('buka-ppdb.pengumuman' , Dits::encodeDits($data->uuid))}}" class="btn btn-info mt-5 btn-sm"><i class="fas fa-plus"></i> Tambah Pengumuman</a>
            <a href="{{route('import.pengumuman.view' , Dits::encodeDits($data->uuid))}}" class="btn btn-info mt-5 btn-sm"><i class="fas fa-upload"></i> Upload Pengumuman</a>
            <a href="{{route('download.file' , ['Documents' , 'format_pengumuman.xlsx'])}}" class="btn btn-info mt-5 btn-sm"><i class="fas fa-download"></i> Format Pengumuman</a>

            <div class="card mt-2">
                <div class="card-body">
                    <h6 class="text-center">Data Peserta Diterima</h6>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mt-5" id="dataDiterima">
                            <thead>
                                <tr>
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
            
            <div class="card mt-5">
                <div class="card-body">
                    <h6 class="text-center">Data Peserta Ditolak</h6>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mt-5" id="dataDitolak">
                            <thead>
                                <tr>
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
    
    <div class="card mt-5">
        <div class="card-body">
            <h6 class="text-center">Data Peserta Daftar Ulang</h6>

            <div class="table-responsive">
                <table class="table table-striped table-hover mt-5" id="daftar-ulang">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nomor Pendaftaran</th>
                            <th>Nama Peserta</th>
                            {{-- <th>Status Diterima</th>
                            <th>Jalur Diterima</th> --}}
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
            
            $('#dataPendaftaran').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'status_pendaftaran', name: 'status_pendaftaran'},
                    {data: 'status_diterima', name: 'status_diterima'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#dataVerifikasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/dataVerifikasi",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.jkl', name: 'peserta.jkl'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#dataDiterima').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/dataDiterima",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'status_diterima', name: 'status_diterima'},
                    {data: 'jalur_diterima', name: 'jalur_diterima'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#dataDitolak').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/dataDitolak",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    {data: 'peserta.alamat_rumah', name: 'peserta.alamat_rumah'},
                    {data: 'status_diterima', name: 'status_diterima'},
                    {data: 'jalur_diterima', name: 'jalur_diterima'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            
            $('#daftar-ulang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/buka-ppdb/detail/"+token+"/data-daftar-ulang",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'peserta.nama', name: 'peserta.nama'},
                    // {data: 'status_diterima', name: 'status_diterima'},
                    // {data: 'jalur_diterima', name: 'jalur_diterima'},
                    {data: 'file_transfer', name: 'file_transfer'},
                    {data: 'status_transfer', name: 'status_transfer'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush

@section('modal')

@foreach ($pendaftaran as $item)    
    <!-- Modal -->
    <div class="modal fade" id="opsi-{{$item->uuid}}" tabindex="-1" role="dialog" aria-labelledby="opsi-{{$item->uuid}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="opsi-{{$item->uuid}}Label">{{$item->peserta['nama']}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{route('buka-ppdb.update.daftar.ulang' , Dits::encodeDits($item->uuid))}}" method="POST" enctype="multipart/form-data">
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

    <!-- Modal -->
    <div class="modal fade" id="addPeserta" tabindex="-1" role="dialog" aria-labelledby="addPesertaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addPesertaLabel">Jalur Khusus</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('import.jalur-khusus')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Upload</label>
                        <input type="file" name="file_import" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('download.file' , ['Documents' , 'format_jalur_khusus.xlsx'])}}" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Jalur Khusus</a>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
          </div>
        </div>
      </div>
@endsection
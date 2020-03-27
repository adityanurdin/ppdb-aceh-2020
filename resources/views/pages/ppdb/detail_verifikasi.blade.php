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
        <li class="bc-item" aria-current="page">Verifikasi Peserta</li>
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

@endsection

@push('script')
<script>
    $(function() {

        $('#dataVerifikasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.data-verifikasi',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'nama', name: 'nama'},
                {data: 'jkl', name: 'jkl'},
                {data: 'alamat_rumah', name: 'alamat_rumah'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1] },
              { className: "min_action text-center", "targets": [5] }
            ],
        });
        
    });
</script>
@endpush
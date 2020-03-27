@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item active" aria-current="page">Madrasah Terpilih</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>NSM</th>
                        <th>Nama Madrasah</th>
                        <th>Kode Pendaftaran</th>
                        <th>Status Pendaftaran</th>
                        <th>Status Penerimaan</th>
                        <th>Jalur Penerimaan</th>
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
<script>
    $(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('buka-ppdb.madrasah-terpilih.data') !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nsm', name: 'nsm'},
                {data: 'nama_madrasah', name: 'nama_madrasah'},
                {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                {data: 'status_pendaftaran', name: 'status_pendaftaran'},
                {data: 'status_diterima', name: 'status_diterima'},
                {data: 'jalur_diterima', name: 'jalur_diterima'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,3,4,5,6] },
              { className: "min_action text-center", "targets": [7] }
            ],
        });
    })
</script>
@endpush
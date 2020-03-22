@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Arsip CAT</li>
        <li class="bc-item active" aria-current="page">{{$tahun}}</li>
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
                        <th>Kode Soal</th>
                        <th>Tanggal Soal</th>
                        <th>Status Bank</th>
                        <th>Crash CAT</th>
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
            ajax: "{!! route('arsip.cat.data',['tahun'=>$tahun]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'madrasah.nsm', name: 'madrasah.nsm'},
                {data: 'madrasah.nama_madrasah', name: 'madrasah.nama_madrasah'},
                {data: 'kode_soal', name: 'kode_soal'},
                {data: 'tgl_bank_soal', name: 'tgl_bank_soal'},
                {data: 'status_bank_soal', name: 'status_bank_soal'},
                {data: 'crash_session', name: 'crash_session'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,3,4,5,6] },
              { className: "min_action text-center", "targets": [7] }
            ],
        });
    });
</script>
@endpush
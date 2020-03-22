@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item active" aria-current="page">Database Madrasah</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('madrasah.create')}}" class="btn btn-info mb-3 float-right"><i class="fa fa-plus"></i> Tambah Madrasah</a>
        <div class="clearfix"></div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th width="15">Kode Satker</th>
                        <th>NSM</th>
                        <th>NPSN</th>
                        <th>Namaa Madrasah</th>
                        <th>Jenjang</th>
                        <th>Kecamatan</th>
                        <th style="min-width:120px;">Opsi</th>
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
            ajax: "{{ route('madrasah.data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode_satker', name: 'kode_satker'},
                {data: 'nsm', name: 'nsm'},
                {data: 'npsn', name: 'npsn'},
                {data: 'nama_madrasah', name: 'nama_madrasah'},
                {data: 'jenjang', name: 'jenjang'},
                {data: 'kecamatan', name: 'kecamatan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,2,3] },
              { className: "min_action text-center", "targets": [7] }
            ],
        });
    });
</script>
@endpush
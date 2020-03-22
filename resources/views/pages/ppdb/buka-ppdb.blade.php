@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Buka PPDB</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('buka-ppdb.create')}}" class="btn btn-info float-right mb-5"><i class="fas fa-plus"></i> Buka
            PPDB</a>
        <div class="clearfix"></div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nama Madrasah</th>
                        <th>Tanggal Pembukaan</th>
                        <th>Tanggal Penutupan</th>
                        <th>Tanggal Pengumuman</th>
                        <th>Status</th>
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
            ajax: "{{ route('buka-ppdb.data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'madrasah.nama_madrasah', name: 'madrasah.nama_madrasah'},
                {data: 'tgl_pembukaan', name: 'tgl_pembukaan'},
                {data: 'tgl_penutupan', name: 'tgl_penutupan'},
                {data: 'tgl_pengumuman', name: 'tgl_pengumuman'},
                {data: 'status_pembukaan', name: 'status_pembukaan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
                { className: "min_id text-center", "targets": [0] },
                { className: "text-center", "targets": [2,3,4,5] },
                { className: "min_action text-center", "targets": [6] }
            ],
        });
    });
</script>
@endpush
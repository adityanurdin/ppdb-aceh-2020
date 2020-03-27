@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item active" aria-current="page">Pilih PPDB</li>
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
                        <th>Tanggal Pembukaan</th>
                        <th>Tanggal Penutupan</th>
                        <th>Tanggal Pengumuman</th>
                        <th width="250">Opsi</th>
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
            ajax: "{!! route('buka-ppdb.dataByID',['id'=>$id]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nsm', name: 'nsm'},
                {data: 'nama_madrasah', name: 'nama_madrasah'},
                {data: 'tgl_pembukaan', name: 'tgl_pembukaan'},
                {data: 'tgl_penutupan', name: 'tgl_penutupan'},
                {data: 'tgl_pengumuman', name: 'tgl_pengumuman'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,3,4,5] },
              { className: "min_action text-center", "targets": [6] }
            ],
        });
    })
</script>
@endpush
@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Menu Kemenag</li>
        <li class="bc-item active" aria-current="page">Data Operator</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('kemenag.create')}}" class="btn btn-info mb-3 float-right"><i class="fa fa-plus"></i> Tambah
            Op.Kemenag</a>
        <div class="clearfix"></div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th width="100">Kode User</th>
                        <th>Satker</th>
                        <th>Nama Operator</th>
                        <th>Email Operator</th>
                        <th>Status Aktif</th>
                        <th width="140">Opsi</th>
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
        ajax: "{{ route('kemenag.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'username', name: 'username'},
            {data: 'satker', name: 'satker'},
            {data: 'nama_operator', name: 'nama_operator'},
            {data: 'email_operator', name: 'email_operator'},
            {data: 'status_aktif', name: 'status_aktif'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs": [
          { className: "min_id text-center", "targets": [0] },
          { className: "text-center", "targets": [5] },
          { className: "min_action text-center", "targets": [6] }
        ],
    });
});
</script>
@endpush
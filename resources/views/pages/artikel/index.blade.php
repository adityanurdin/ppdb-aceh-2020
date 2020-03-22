@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Web Informasi</li>
        <li class="bc-item" aria-current="page">Artikel</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('artikel.create')}}" class="btn btn-sm btn-success mb-5"><i class="fas fa-plus"></i>
            Post
            Artikel</a>
        <div class="clearfix"></div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="table-artikel">
                <thead>
                    <tr class="text-center">
                        <td>ID</td>
                        <td width="50%">Judul Artikel</td>
                        <td>Status</td>
                        <td>Publisher</td>
                        <td>Opsi</td>
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
    $('#table-artikel').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('artikel.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'judul_artikel', name: 'judul_artikel'},
            {data: 'status_artikel', name: 'status_artikel'},
            {data: 'publisher', name: 'publisher'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs": [
            { className: "min_id text-center", "targets": [0] },
            { className: "text-center", "targets": [2] },
            { className: "min_action text-center", "targets": [4] }
        ],
    });

})
</script>
@endpush
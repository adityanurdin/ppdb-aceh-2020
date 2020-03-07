@extends('layouts.backend.index')  

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Web Informasi</li>
        <li class="bc-item active" aria-current="page">Video</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            
            <a href="{{route('video.create')}}" class="btn btn-sm btn-success mb-5"><i class="fas fa-plus"></i> Post Video</a>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="table-video">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Judul Video</td>
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
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var token = $('#params').val();
            
            $('#table-video').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('video.data')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'judul_video', name: 'judul_video'},
                    {data: 'status_video', name: 'status_video'},
                    {data: 'publisher', name: 'publisher'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        })
    </script>
@endpush
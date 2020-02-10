@extends('layouts.backend.index')

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
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
            
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('buka-ppdb.madrasah-terpilih.data')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nsm', name: 'nsm'},
                    {data: 'nama_madrasah', name: 'nama_madrasah'},
                    {data: 'kode_pendaftaran', name: 'kode_pendaftaran'},
                    {data: 'status_pendaftaran', name: 'status_pendaftaran'},
                    {data: 'status_diterima', name: 'status_diterima'},
                    {data: 'jalur_diterima', name: 'jalur_diterima'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        })
    </script>
@endpush
@extends('layouts.backend.index')

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route('madrasah.create')}}" class="btn btn-info mb-3 float-right">Tambah Madrasah</a>
            <table class="table table-borderless table-sm table-responsive table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="15">Kode Satker</th>
                        <th>NSM</th>
                        <th>NPSN</th>
                        <th>Namaa Madrasah</th>
                        <th>Jenjang</th>
                        <th>Kecamatan</th>
                        <th width="75">Opsi</th>
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
                ]
            });


        });
    </script>
@endpush
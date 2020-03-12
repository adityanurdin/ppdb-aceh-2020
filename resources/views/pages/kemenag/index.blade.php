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
            <a href="{{route('kemenag.create')}}" class="btn btn-info mb-3 float-right">Tambah Op.Kemenag</a>
            <table class="table table-borderless table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="15">Kode User</th>
                        <th>Satker</th>
                        <th>Nama Operator</th>
                        {{-- <th>Kontak Operator</th> --}}
                        <th>Email Operator</th>
                        {{-- <th>Aktif</th> --}}
                        <th width="140">Opsi</th>
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
                ajax: "{{ route('kemenag.data') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'username', name: 'username'},
                    {data: 'satker', name: 'satker'},
                    {data: 'nama_operator', name: 'nama_operator'},
                    // {data: 'kontak_operator', name: 'kontak_operator'},
                    {data: 'email_operator', name: 'email_operator'},
                    // {data: 'user.status_aktif', name: 'user.status_aktif'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush
@extends('layouts.backend.index')

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
@endsection

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route('buka-ppdb.create')}}" class="btn btn-info float-right mb-5"><i class="fas fa-plus"></i> Buka PPDB</a>
            <table class="table table-borderless table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Madrasah</th>
                        <th>Tanggal Pembukaan</th>
                        <th>Tanggal Penutupan</th>
                        <th>Tanggal Pengumuman</th>
                        {{-- <th>Tanggal Pengumuman</th> --}}
                        <th>Status</th>
                        <th width="135">Opsi</th>
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
                ajax: "{{ route('buka-ppdb.data') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'madrasah.nama_madrasah', name: 'madrasah.nama_madrasah'},
                    {data: 'tgl_pembukaan', name: 'tgl_pembukaan'},
                    {data: 'tgl_penutupan', name: 'tgl_penutupan'},
                    {data: 'tgl_pengumuman', name: 'tgl_pengumuman'},
                    {data: 'status_pembukaan', name: 'status_pembukaan'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush
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
        <li class="bc-item" aria-current="page">Arsip CAT</li>
        <li class="bc-item active" aria-current="page">{{$tahun}}</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <a href="{{route('bank-soal.create')}}" class="btn btn-info btn-sm float-right mb-5"><i class="fas fa-plus"></i> Tambah Bank Soal</a> --}}
            <table class="table table-borderless table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NSM</th>
                        <th>Nama Madrasah</th>
                        <th>Kode Soal</th>
                        <th>Tanggal Soal</th>
                        <th>Status Bank</th>
                        <th>Crash CAT</th>
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
<input type="hidden" name="" id="params" value="{{$tahun}}">

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
                ajax: "/arsip/CAT/"+token+"/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'madrasah.nsm', name: 'madrasah.nsm'},
                    {data: 'madrasah.nama_madrasah', name: 'madrasah.nama_madrasah'},
                    {data: 'kode_soal', name: 'kode_soal'},
                    {data: 'tgl_bank_soal', name: 'tgl_bank_soal'},
                    {data: 'status_bank_soal', name: 'status_bank_soal'},
                    {data: 'crash_session', name: 'crash_session'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush
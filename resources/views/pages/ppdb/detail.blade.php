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
            <h4 class="text-center">{{$data->madrasah['nama_madrasah']}}</h4>
            <div class="row mt-5 ml-5">
                <div class="col-md-4">
                    <p class="text-dark">Tanggal Pembukaan</p>
                    <p class="text-dark">Tanggal Penutupan</p>
                    <p class="text-dark">Tanggal Pengumuman</p>
                    <p class="text-dark">Status Pembukaan</p>
                </div>
                <div class="col-md-8">
                    <p class="text-dark">: {{$data->tgl_pembukaan}}</p>
                    <p class="text-dark">: {{$data->tgl_penutupan}}</p>
                    <p class="text-dark">: {{$data->tgl_pengumuman}}</p>
                    <p class="text-dark">: {{$data->status_pembukaan}}</p>
                </div>
            </div>
            <div class="container mt-5 text-center">
                <a href="{{Dits::PdfViewer(asset($data->url_brosur))}}" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Lihat Brosur</a>
                <a href="{{route('buka-ppdb.rubah-status' , Dits::encodeDits($data->uuid))}}" class="btn btn-sm btn-info"><i class="fas fa-pen-square"></i> Ubah Status</a>
                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-pen-square"></i> Edit Pembukaan</a>
                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-pen-square"></i> Hapus Pembukaan</a>
                <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Data</a>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <h6 class="text-center">Data Peserta Pendaftaran</h6>

            <table class="table table-borderless table-hover mt-5" id="myTable">
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
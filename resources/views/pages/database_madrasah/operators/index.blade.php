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
<input type="hidden" id="params" value="{{Dits::encodeDits($data->uuid)}}">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-5" style="font-weight: 700">Tambah Operator Madrasah ( {{$data->nama_madrasah}} )</div>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                    </div>
                    <div class="form-group">
                        <label for="">No Telepon</label>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                    </div>
                </div>
                <div class="col-md-10">
                    <form action="{{route('madrasah.operators.store' , Dits::encodeDits($data->uuid))}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" name="nama_operator" placeholder="Nama Lengkap .." class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <input type="number" name="kontak_operator" placeholder="No Telepon .." class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email_operator" placeholder="Email .." class="form-control" id="">
                        </div>

                        <button type="submit" class="btn btn-info btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <table class="table table-borderless table-sm table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode User</th>
                        <th>Nama Operator</th>
                        <th>Kontak Operator</th>
                        <th>Email Operator</th>
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
                ajax: "/kemenag/madrasah/operators/"+ token + "/data",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'nama_operator', name: 'nama_operator'},
                    {data: 'kontak_operator', name: 'kontak_operator'},
                    {data: 'email_operator', name: 'email_operator'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


        });
    </script>
@endpush
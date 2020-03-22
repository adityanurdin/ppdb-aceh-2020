@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item"><a href="{{route('madrasah.index')}}">Database Madrasah</a></li>
        <li class="bc-item active" aria-current="page">Tambah Operator Madrasah</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-5" style="font-weight: 700">
                    Tambah Operator Madrasah ( {{$data->nama_madrasah}} )
                </div>
                <hr>
                <form action="{{route('madrasah.operators.store' , Dits::encodeDits($data->uuid))}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nama Lengkap *</label>
                        <input type="text" name="nama_operator" placeholder="Nama Lengkap .."
                            class="form-control  @error('nama_operator') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('nama_operator')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">No Telepon *</label>
                        <input type="text" name="kontak_operator" placeholder="No Telepon .."
                            class="form-control  @error('kontak_operator') is-invalid @enderror" autocomplete="off"
                            maxlength="30" required>
                        @error('kontak_operator')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email *</label>
                        <input type="email" name="email_operator" placeholder="Email .."
                            class="form-control  @error('email_operator') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('email_operator')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-save"></i> SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Kode User</th>
                        <th>Nama Operator</th>
                        <th>Kontak Operator</th>
                        <th>Email Operator</th>
                        <th>Status Aktif</th>
                        <th width="135">Opsi</th>
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
            ajax: "{!! route('madrasah.operators.data',['id'=>Dits::encodeDits($data->uuid)]) !!}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user.username', name: 'user.username'},
                {data: 'nama_operator', name: 'nama_operator'},
                {data: 'kontak_operator', name: 'kontak_operator'},
                {data: 'email_operator', name: 'email_operator'},
                {data: 'user.status_aktif', name: 'user.status_aktif'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,2,3,5] },
              { className: "min_action text-center", "targets": [6] }
            ],
        });
    });
</script>
@endpush
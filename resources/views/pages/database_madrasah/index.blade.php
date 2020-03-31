@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item active" aria-current="page">Database Madrasah</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{route('export.operator')}}" class="btn btn-success m-1 float-left"><i class="fa fa-file-excel"></i>
            Export Operator</a>
        <a href="" data-toggle="modal" data-target="#ResetAkun" class="btn btn-dark m-1 float-left"><i
                class="fas fa-user-clock"></i> Reset Akun Operator</a>
        <a href="{{route('madrasah.create')}}" class="btn btn-info m-1 float-right"><i class="fa fa-plus"></i> Tambah
            Madrasah</a>
        <div class="clearfix mb-3"></div>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th width="15">Kode Satker</th>
                        <th>NSM</th>
                        <th>NPSN</th>
                        <th>Namaa Madrasah</th>
                        <th>Jenjang</th>
                        <th>Kecamatan</th>
                        <th style="min-width:120px;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Reset Akun Peserta --}}
<div class="modal fade" id="ResetAkun" tabindex="-1" role="dialog" aria-labelledby="ResetAkunLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="ResetAkunLabel"><i class="fa fa-user-clock"></i> Reset Akun Peserta
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('import.reset.op')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body bg-white text-dark">
                    <div class="form-group">
                        <label for="">File Reset Akun *</label>
                        <input type="file" name="file_upload" id=""
                            class="form-control @error('file_import') is-invalid @enderror" required>
                        <small>File : .CSV (MS-Dos/Comma Delimited) | Ukuran Maksimal : 1000KB/1MB</small>
                        @error('file_import')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('download.file' , ['Documents' , 'format_reset_akun_operator.xlsx'])}}"
                        class="btn btn-secondary btn-sm"><i class="fas fa-download"></i> Format Reset Akun</a>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> UPLOAD</button>
                </div>

            </form>
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
            ],
            "columnDefs": [
              { className: "min_id text-center", "targets": [0] },
              { className: "text-center", "targets": [1,2,3] },
              { className: "min_action text-center", "targets": [7] }
            ],
        });
    });
</script>
@endpush
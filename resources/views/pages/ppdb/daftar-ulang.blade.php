@extends('layouts.backend.index')

@section('css')
<style>
    .card-header {
        text-align: center;
        background-color: #009DDD;
        color: whitesmoke;
        font-weight: 600;
    }
</style>
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item"><a href="{{URL::previous()}}"><i class="fas fa-home"></i> Madrasah Terpilih</a></li>
        <li class="bc-item active" aria-current="page">Daftar Ulang</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white text-left">
                <h6><i class="fa fa-coins"></i> Bukti Daftar Ulang</h6>
            </div>
            <div class="card-body">
                @if ($data->url_transfer != '')
                <a href="{{Dits::PdfViewer(asset($data->url_transfer))}}" target="_blank"
                    class="btn btn-info btn-block"><i class="fa fa-eye"></i> Buka File</a>
                <a href="{{route('buka-ppdb.daftar-ulang.hapus-file' , $kode)}}" class="btn btn-danger btn-block"
                    onclick="return confirm('Anda Yakin Menghapus File Ini?')"><i class="fa fa-trash"></i> Hapus
                    File</a>
                @else
                <form action="{{route('buka-ppdb.daftar-ulang' , $kode)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="url_transfer">Pilih File *</label>
                                <input type="file" name="url_transfer" id="url_transfer"
                                    class="form-control @error('url_transfer') is-invalid @enderror" autocomplete="off"
                                    required>
                                <small>File Yang Diizinkan : JPG,JPEG,PNG,PDF | Maksimal Ukuran : 1000KB</small>
                                @error('url_transfer')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-upload"></i>
                        UPLOAD</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
@endsection
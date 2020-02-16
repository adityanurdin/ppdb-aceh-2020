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

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Daftar Ulang
                </div>
                <div class="card-body">
                    @if ($data->url_transfer != '')
                        <a href="{{Dits::PdfViewer(asset($data->url_transfer))}}" target="_blank" class="btn btn-info btn-block">Buka File</a>
                        <a href="{{route('buka-ppdb.daftar-ulang.hapus-file' , $kode)}}" class="btn btn-danger btn-block">Hapus File</a>
                    @else
                        <form action="{{route('buka-ppdb.daftar-ulang' , $kode)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mt-2">
                                        Upload File
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="file" name="url_transfer" id="" class="form-control">
                                        <small>File Yang Diizinkan : JPG,JPEG,PNG,PDF | Maksimal Ukuran : 300KB</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-sm float-right">Simpan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
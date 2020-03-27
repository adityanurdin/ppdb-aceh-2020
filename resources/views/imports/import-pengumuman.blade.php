@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Buka PPDB</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Detail</a></li>
        <li class="bc-item active" aria-current="page">Upload Pengumuman</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('import.pengumuman' , Dits::encodeDits($uuid))}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                File Pengumuman :
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="file" name="file_import" id="" class="form-control @error('file_import') is-invalid @enderror" >
                                <small>File : .CSV (MS-Dos/Comma Delimited) | Ukuran Maksimal : 1000KB/1MB</small>
                                @error('file_import')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-upload"></i> UPLOAD</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection
@extends('layouts.backend.index')

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('import.pengumuman' , Dits::encodeDits($uuid))}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    File Pengumuman :
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="file" name="file_import" id="" class="form-control">
                                    <small>File : .CSV (MS-Dos/Comma Delimited) | Ukuran Maksimal : 1000KB/1MB</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
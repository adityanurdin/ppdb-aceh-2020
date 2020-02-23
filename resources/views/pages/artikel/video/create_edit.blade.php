@extends('layouts.backend.index')

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <div class="card">
        <div class="card-body">
                    <form action="{{ isset($slug) ? route('video.update' , $data->uuid) : route('video.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($slug)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="">Judul Video</label>
                            <input type="text" value="{{isset($slug) ? $data->judul_video : ''}}" name="judul_video" id="" placeholder="Judul Video.." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">URL Video Youtube</label>
                            <input type="text" name="url_video" value="{{isset($slug) ? $data->url_video : ''}}" id="" placeholder="contoh : FrYAJ1Cjapc" class="form-control">
                            <small>Ambil Kode Setelah (watch?v=) Pada Link Youtube Anda, Ex :https://www.youtube.com/watch?v=<b>FrYAJ1Cjapc</b></small>
                        </div>
                        <div class="form-group">
                            <label for="">Thumbnail Video</label>
                            <input type="file" name="thumbnail_video" id="" class="form-control">
                            <small>File Yang Diizinkan : JPG,JPEG,PNG | Maksimal Ukuran : 300KB</small>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi Video</label>
                            <textarea name="deskripsi_video" id="" cols="30" rows="10" class="form-control">{{isset($slug) ? $data->deskripsi_video : ''}}</textarea>
                            <small>Pisahkan Dengan Tanda Koma (,)</small>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm float-right">Publish</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    @isset($slug)  
    <div class="card mt-5">
        <div class="card-body">
            <h6 class="mb-5 text-center">Preview Video</h6>
            <div class="text-center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $data->url_video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    @endisset
@endsection
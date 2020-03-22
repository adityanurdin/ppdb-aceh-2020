@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Web Informasi</li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Video</a></li>
        <li class="bc-item active" aria-current="page">Post / Edit Video</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($slug) ? route('video.update' , $data->uuid) : route('video.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($slug)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label for="">Judul Video *</label>
                        <input type="text" value="{{isset($slug) ? $data->judul_video : ''}}" name="judul_video" id=""
                            placeholder="Judul Video.." class="form-control @error('judul_video') is-invalid @enderror"
                            autocomplete="off" maxlength="300" required>
                        @error('judul_video')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">URL Video Youtube *</label>
                        <input type="text" name="url_video" value="{{isset($slug) ? $data->url_video : ''}}" id=""
                            placeholder="contoh : FrYAJ1Cjapc"
                            class="form-control @error('url_video') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        <small>Ambil Kode Setelah (watch?v=) Pada Link Youtube Anda, Ex
                            :https://www.youtube.com/watch?v=<b>FrYAJ1Cjapc</b></small>
                        @error('url_video')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Thumbnail Video</label>
                        <input type="file" name="thumbnail_video" id=""
                            class="form-control @error('thumbnail_video') is-invalid @enderror" autocomplete="off">
                        <small>File Yang Diizinkan : JPG,JPEG,PNG | Maksimal Ukuran : 300KB</small>
                        @error('thumbnail_video')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Video</label>
                        <textarea name="deskripsi_video" id="" cols="30" rows="10"
                            class="form-control @error('deskripsi_video') is-invalid @enderror" autocomplete="off"
                            maxlength="300">
                            {{isset($slug) ? $data->deskripsi_video : ''}}
                        </textarea>
                        <small>Pisahkan Dengan Tanda Koma (,)</small>
                        @error('deskripsi_video')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-cloud-upload-alt"></i>
                        PUBLISH</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@isset($slug)
<div class="card mt-5">
    <div class="card-body">
        <div class="p-3 text-center badge-dark text-uppercase">
            <h3><i class="fa fa-play-circle"></i> Preview Video</h3>
        </div>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $data->url_video }}"></iframe>
        </div>
    </div>
</div>
@endisset
@endsection
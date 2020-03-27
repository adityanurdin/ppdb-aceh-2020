@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Web Informasi</li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Artikel</a></li>
        <li class="bc-item active" aria-current="page">Post / Edit Artikel</li>
    </ol>
</nav>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($slug) ? route('artikel.update' , $data->uuid) : route('artikel.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($slug)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label for="">Judul Artikel *</label>
                        <input type="text" value="{{isset($slug) ? $data->judul_artikel : ''}}" name="judul_artikel"
                            id="" class="form-control @error('judul_artikel') is-invalid @enderror"
                            placeholder="Judul Artikel.." autocomplete="off" maxlength="300" required>
                        @error('judul_artikel')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Thumbnail Artikel</label>
                        <input type="file" name="thumbnail_artikel" id=""
                            class="form-control @error('thumbnail_artikel') is-invalid @enderror" autocomplete="off">
                        @error('thumbnail_artikel')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Artikel *</label>
                        <textarea name="deskripsi_artikel" id="" cols="30" rows="10"
                            class="form-control @error('deskripsi_artikel') is-invalid @enderror"
                            required>{{isset($slug) ? $data->deskripsi_artikel : ''}}</textarea>
                        <small>Pisahkan Dengan Tanda Koma (,)</small>
                        @error('deskripsi_artikel')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Tulis Artikel *</label>
                        <textarea id="summernote" name="isi_artikel" class=" @error('isi_artikel') is-invalid @enderror"
                            required>
                            {{isset($slug) ? $data->isi_artikel : ''}}
                        </textarea>
                        @error('isi_artikel')
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
@endsection

@push('script')
<script>
    $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: '',
                tabsize: 2,
                minHeight: 500,
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen']]
                ]
            });
        });
</script>
@endpush
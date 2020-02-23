@extends('layouts.backend.index')

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
                    <form action="{{route('artikel.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Judul Artikel</label>
                            <input type="text" name="judul_artikel" id="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Thumbnail Artikel</label>
                            <input type="file" name="thumbnail_artikel" id="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi Artikel</label>
                            <textarea name="deskripsi_artikel" id="" cols="30" rows="10" class="form-control"></textarea>
                            <small>Pisahkan Dengan Tanda Koma (,)</small>
                        </div>
                        <div class="form-group">
                            <label for="">Tulis Artikel</label>
                            <textarea id="summernote" name="isi_artikel"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-info float-right">Publish</button>
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
                // height: 100,
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
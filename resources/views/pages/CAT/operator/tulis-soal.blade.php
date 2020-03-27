@extends('layouts.backend.index')

@section('css')
<style>
    .card-header {
        text-align: center;
        background-color: #11AFF0;
        color: whitesmoke;
        font-weight: 700;
    }
    textarea.summernote{
        color: #000 !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Bank Soal</li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Tulis Soal</a></li>
        <li class="bc-item active" aria-current="page">{{$data->kode_soal}}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header text-white bg-secondary">
        <h6 class="text-center"><i class="fa fa-plus"></i> Tulis Soal Pada Kode Soal [ {{$data->kode_soal}} ]</h6>
    </div>
    <div class="card-body px-4">
        <form
            action="{{ $edit == true ? route('bank-soal.update.soal' , Dits::encodeDits($data->uuid)) : route('bank-soal.store.soal' , $data->kode_soal) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if($edit == true)
            @method('PUT')
            @endif
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Jenis Soal/Mapel *</label>
                    <select class="col-md-9 col-sm-12 form-control @error('jenis_soal') is-invalid @enderror"
                        name="jenis_soal" id="" required>
                        <option value="" disabled selected>-Pilih Jenis Soal</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Agama') : ''}} value="Agama">
                            Agama</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Arab') : ''}}
                            value="Bahasa Arab">Bahasa Arab</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Indonesia') : ''}}
                            value="Bahasa Indonesia">Bahasa Indonesia</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Inggris') : ''}}
                            value="Bahasa Inggris">Bahasa Inggris</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa IPA') : ''}} value="IPA">
                            Ilmu Pengetahuan Alam (IPA)</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa IPS') : ''}} value="IPS">
                            Ilmu Pengetahuan Sosial (IPS)</option>
                        <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Matematika') : ''}}
                            value="Matematika">Matematika</option>
                    </select>
                    @error('jenis_soal')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Nomor Soal *</label>
                    <input type="number" value="{{isset($edit) ? $data->nomor_soal : ''}}"
                        class="col-md-9 col-sm-12 form-control  @error('nomor_soal') is-invalid @enderror"
                        name="nomor_soal" min="1" autocomplete="off" maxlength="5" required>
                    @error('nomor_soal')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Soal *</label>
                    <div class="col-md-9 col-sm-12">
                        <textarea id="summernote" class="summernote" name="soal" required>{{isset($edit) ? $data->soal : ''}}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    @if($edit == true)
                    <label class="col-md-3 col-sm-12" for="">Gambar</label>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file"
                                class="col-md-9 col-sm-12 form-control  @error('gambar') is-invalid @enderror"
                                name="gambar">
                            @error('gambar')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <a href="{{Dits::imageUrl($data->gambar)}}" target="_blank"
                                class="btn btn-info btn-sm btn-block">Lihat Gambar Sebelumnya</a>
                        </div>
                    </div>
                    @else
                    <label class="col-md-3 col-sm-12" for="">Gambar</label>
                    <input type="file" class="col-md-9 col-sm-12 form-control  @error('gambar') is-invalid @enderror"
                        name="gambar">
                    @error('gambar')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Jawaban A *</label>
                    <input type="text" value="{{isset($edit) ? $data->a : ''}}"
                        class="col-md-9 col-sm-12 form-control  @error('a') is-invalid @enderror" name="a"
                        autocomplete="off" maxlength="500" required>
                    @error('a')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Jawaban B *</label>
                    <input type="text" value="{{isset($edit) ? $data->b : ''}}"
                        class="col-md-9 col-sm-12 form-control  @error('b') is-invalid @enderror" name="b"
                        autocomplete="off" maxlength="500" required>
                    @error('b')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Jawaban C *</label>
                    <input type="text" value="{{isset($edit) ? $data->c : ''}}"
                        class="col-md-9 col-sm-12 form-control  @error('c') is-invalid @enderror" name="c"
                        autocomplete="off" maxlength="500" required>
                    @error('c')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Jawaban D *</label>
                    <input type="text" value="{{isset($edit) ? $data->d : ''}}"
                        class="col-md-9 col-sm-12 form-control  @error('d') is-invalid @enderror" name="d"
                        autocomplete="off" maxlength="500" required>
                    @error('d')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 col-sm-12" for="">Kunci Jawaban *</label>
                    <select class="col-md-9 col-sm-12 form-control  @error('kunci_jawaban') is-invalid @enderror"
                        name="kunci_jawaban" id="" required>
                        <option disabled selected>-Pilih Kunci Jawaban</option>
                        <option {{isset($edit) ? Dits::selected($data->kunci_jawaban, 'A') : ''}} value="A">A
                        </option>
                        <option {{isset($edit) ? Dits::selected($data->kunci_jawaban, 'B') : ''}} value="B">B
                        </option>
                        <option {{isset($edit) ? Dits::selected($data->kunci_jawaban, 'C') : ''}} value="C">C
                        </option>
                        <option {{isset($edit) ? Dits::selected($data->kunci_jawaban, 'D') : ''}} value="D">D
                        </option>
                    </select>
                    @error('kunci_jawaban')
                    <div class="invalid-feedback text-left">
                        <label>{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <button class="btn btn-info btn-sm float-right" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
        </form>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 100,
                maxHeight: 100,
                minHeight: 100,
                toolbar: [
                ['font', ['bold', 'underline', 'clear' , 'italic']],
                ['color', ['black']],
                ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        });
</script>
@endpush
@extends('layouts.backend.index')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item"><a href="{{route('madrasah.index')}}">Database Madrasah</a></li>
        <li class="bc-item active" aria-current="page">Tambah/Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form
                    action="{{ isset($data) ? route('madrasah.update' , Dits::encodeDits($data->uuid)) : route('madrasah.store')}}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($data)
                    @method('PUT')
                    @endisset

                    <div class="form-group">
                        <label for="">Kode Satker *</label>
                        <input type="text" value="{{isset($data) ? $data->kode_satker : ''}}" name="kode_satker"
                            class="form-control  @error('kode_satker') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('kode_satker')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">NSM *</label>
                        <input type="text" value="{{isset($data) ? $data->nsm : ''}}" name="nsm"
                            class="form-control  @error('nsm') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('nsm')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">NPSN *</label>
                        <input type="text" value="{{isset($data) ? $data->npsn : ''}}" name="npsn"
                            class="form-control  @error('npsn') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('npsn')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Jenjang *</label>
                        <select class="form-control  @error('jenjang') is-invalid @enderror" name="jenjang"
                            required>
                            @if (isset($data))
                            <option @if($data->jenjang=="MI") selected @endif value="MI">MI</option>
                            <option @if($data->jenjang=="MTs") selected @endif value="MTs">MTs</option>
                            <option @if($data->jenjang=="MA") selected @endif value="MA">MA</option>
                            @else
                            <option value="" disabled selected>-Pilih Jenjang</option>
                            <option value="MI">MI</option>
                            <option value="MTs">MTs</option>
                            <option value="MA">MA</option>
                            @endif
                        </select>
                        @isset($data)
                        <small>Pilihan Saat ini : {{$data->jenjang}}</small>
                        @endisset
                        @error('jenjang')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Nama Madrasah *</label>
                        <input type="text" value="{{isset($data) ? $data->nama_madrasah : ''}}" name="nama_madrasah"
                            class="form-control  @error('nama_madrasah') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('nama_madrasah')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Alamat *</label>
                        <input type="text" value="{{isset($data) ? $data->alamat : ''}}" name="alamat"
                            class="form-control  @error('alamat') is-invalid @enderror" autocomplete="off"
                            maxlength="300" required>
                        @error('alamat')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Kelurahan *</label>
                        <input type="text" value="{{isset($data) ? $data->kelurahan : ''}}" name="kelurahan"
                            class="form-control  @error('kelurahan') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('kelurahan')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Kecamatan *</label>
                        <input type="text" value="{{isset($data) ? $data->kecamatan : ''}}" name="kecamatan"
                            class="form-control  @error('kecamatan') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('kecamatan')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Kabupaten *</label>
                        <input type="text" value="{{isset($data) ? $data->kabupaten : ''}}" name="kabupaten"
                            class="form-control  @error('kabupaten') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('kabupaten')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Provinsi *</label>
                        <input type="text" value="{{isset($data) ? $data->provinsi : ''}}" name="provinsi"
                            class="form-control  @error('provinsi') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('provinsi')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email Madrasah *</label>
                        <input type="email" value="{{isset($data) ? $data->email_madrasah : ''}}" name="email_madrasah"
                            class="form-control  @error('email_madrasah') is-invalid @enderror" autocomplete="off"
                            maxlength="100" required>
                        @error('email_madrasah')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Kontak Madrasah *</label>
                        <input type="text" value="{{isset($data) ? $data->kontak_madrasah : ''}}"
                            name="kontak_madrasah" class="form-control  @error('kontak_madrasah') is-invalid @enderror"
                            autocomplete="off" maxlength="30" required>
                        @error('kontak_madrasah')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Akreditasi Madrasah *</label>
                        <select class="form-control  @error('akreditasi') is-invalid @enderror" name="akreditasi"
                            required id="exampleFormControlSelect1">
                            @if (isset($data))
                            <option  @if($data->jenjang=="Belum Akreditasi") selected @endif value="Belum Akreditasi">Belum Akreditasi</option>
                            <option  @if($data->jenjang=="Terakreditasi") selected @endif value="Terakreditasi">Terkreditasi</option>
                            <option  @if($data->jenjang=="Terakreditasi A") selected @endif value="Terakreditasi A">Terakreditasi A</option>
                            <option  @if($data->jenjang=="Terakreditasi B") selected @endif value="Terakreditasi B">Terakreditasi B</option>
                            <option  @if($data->jenjang=="Terakreditasi C") selected @endif value="Terakreditasi C">Terakreditasi C</option>
                            <option  @if($data->jenjang=="Terakreditasi D") selected @endif value="Terakreditasi D">Terakreditasi D</option>
                            @else
                            <option disabled selected>-Pilih Akreditasi</option>
                            <option value="Belum Akreditasi">Belum Akreditasi</option>
                            <option value="Terakreditasi">Terkreditasi</option>
                            <option value="Terakreditasi A">Terakreditasi A</option>
                            <option value="Terakreditasi B">Terakreditasi B</option>
                            <option value="Terakreditasi C">Terakreditasi C</option>
                            <option value="Terakreditasi D">Terakreditasi D</option>
                            @endif
                        </select>
                        @isset($data)
                        <small>Pilihan Saat ini : {{$data->akreditasi}}</small>
                        @endisset
                        @error('akreditasi')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Logo Madrasah</label>
                        <div class="custom-file">
                            <input type="file" name="logo_madrasah" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Pilih Logo</label>
                        </div>
                        <small>File Yang Diizinkan : JPG,JPEG,PNG | Maksimal Ukuran : 300KB</small>
                    </div>
                    @isset($data)
                    <div class="form-group">
                        <label for="">Logo saat ini {{ $data->logo_madrasah == NULL ? '(default)' : ''}}</label>
                        <br>
                        <img src="{{Dits::imageUrl($data->logo_madrasah)}}" class="img-thumbnail" width="115px"
                            height="115px" alt="">
                    </div>
                    @endisset
                    <div class="form-group">
                        <label for="">Preview Madrasah</label>
                        <textarea id="summernote" name="preview" maxlength="1000">{{isset($data) ? $data->preview : ''}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> SIMPAN</button>

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
                height: 100,
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
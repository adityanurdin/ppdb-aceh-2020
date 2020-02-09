@extends('layouts.backend.index')

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
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
                    <form action="{{ isset($data) ? route('madrasah.update' , Dits::encodeDits($data->uuid)) : route('madrasah.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($data)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            <label for="">Kode Satker</label>
                            <input type="number" value="{{isset($data) ? $data->kode_satker : ''}}" name="kode_satker" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">NSM</label>
                            <input type="number" value="{{isset($data) ? $data->nsm : ''}}" name="nsm" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">NPSN</label>
                            <input type="number" value="{{isset($data) ? $data->npsn : ''}}" name="npsn" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Jenjang</label>
                            <select class="form-control" name="jenjang" required id="exampleFormControlSelect1">
                                <option disabled selected>-Pilih Jenjang</option>
                                <option value="MI">MI</option>
                                <option value="MTs">MTs</option>
                                <option value="MA">MA</option>
                              </select>
                              @isset($data)
                              <small>Pilihan Saat ini : {{$data->jenjang}}</small>
                              @endisset
                        </div>
                        <div class="form-group">
                            <label for="">Nama Madrasah</label>
                            <input type="text" value="{{isset($data) ? $data->nama_madrasah : ''}}" name="nama_madrasah" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" value="{{isset($data) ? $data->alamat : ''}}" name="alamat" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <input type="text" value="{{isset($data) ? $data->kelurahan : ''}}" name="kelurahan" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <input type="text" value="{{isset($data) ? $data->kecamatan : ''}}" name="kecamatan" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Kabupaten</label>
                            <input type="text" value="{{isset($data) ? $data->kabupaten : ''}}" name="kabupaten" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <input type="text" value="{{isset($data) ? $data->provinsi : ''}}" name="provinsi" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Email Madrasah</label>
                            <input type="email" value="{{isset($data) ? $data->email_madrasah : ''}}" name="email_madrasah" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Kontak Madrasah</label>
                            <input type="number" value="{{isset($data) ? $data->kontak_madrasah : ''}}" name="kontak_madrasah" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Akreditasi Madrasah</label>
                            <select class="form-control" name="akreditasi" required id="exampleFormControlSelect1">
                                <option disabled selected>-Pilih Akreditasi</option>
                                <option value="Belum Akreditasi">Belum Akreditasi</option>
                                <option value="Terakreditasi">Terkreditasi</option>
                                <option value="Terakreditasi A">Terakreditasi A</option>
                                <option value="Terakreditasi B">Terakreditasi B</option>
                                <option value="Terakreditasi C">Terakreditasi C</option>
                                <option value="Terakreditasi D">Terakreditasi D</option>
                              </select>
                              @isset($data)
                              <small>Pilihan Saat ini : {{$data->akreditasi}}</small>
                              @endisset
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
                            <img src="{{Dits::imageUrl($data->logo_madrasah)}}" class="img-thumbnail" width="115px" height="115px" alt="">
                        </div>
                        @endisset
                        <div class="form-group">
                            <label for="">Preview Madrasah</label>
                            <textarea id="summernote" name="preview">{{isset($data) ? $data->preview : ''}}</textarea>
                        </div>

                        <button type="submit" class="btn btn-info float-right">Simpan</button>
                        
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
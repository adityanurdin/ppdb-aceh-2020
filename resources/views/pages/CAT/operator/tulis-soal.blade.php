@extends('layouts.backend.index')

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <style>
        .card-header {
            text-align: center;
            background-color: #11AFF0;
            color: whitesmoke;
            font-weight: 700;
        }
    </style>
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Tulis Soal Pada Kode Soal [ {{$data->kode_soal}} ]
        </div>
        <div class="card-body">
            <form action="{{ $edit == true ? route('bank-soal.update.soal' , Dits::encodeDits($data->uuid)) : route('bank-soal.store.soal' , $data->kode_soal) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($edit == true)
                    @method('PUT')
                @endif
                <div class="container mt-3">
    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                Jenis Soal/Mapel
                            </div>
                            <div class="form-group" style="margin-top: 23px;">
                                Nomor Soal
                            </div>
                            <div class="form-group" style="margin-top: 26px;">
                                Soal
                            </div>
                            <div class="form-group" style="margin-top: 150px;">
                                Gambar
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                Jawaban A
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                Jawaban B
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                Jawaban C
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                Jawaban D
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                Kunci Jawaban
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
                                <select class="form-control form-control-sm" name="jenis_soal" id="exampleFormControlSelect1">
                                  <option disabled selected>-Pilih Jenis Soal</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Agama') : ''}} value="Agama">Agama</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Arab') : ''}} value="Bahasa Arab">Bahasa Arab</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Indonesia') : ''}} value="Bahasa Indonesia">Bahasa Indonesia</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Inggris') : ''}} value="Bahasa Inggris">Bahasa Inggris</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa IPA') : ''}} value="IPA">Ilmu Pengetahuan Alam (IPA)</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa IPS') : ''}} value="IPS">Ilmu Pengetahuan Sosial (IPS)</option>
                                  <option {{isset($edit) ? Dits::selected($data->jenis_soal , 'Bahasa Matematika') : ''}} value="Matematika">Matematika</option>
                                </select>
                              </div>
                              <div class="form-group">
                                  <input type="number" value="{{isset($edit) ? $data->nomor_soal : ''}}" class="form-control form-control-sm" name="nomor_soal">
                              </div>
                              <div class="form-group">
                                <textarea id="summernote" name="soal">{{isset($edit) ? $data->soal : ''}}</textarea>
                              </div>
                              <div class="form-group">
                                  @if($edit == true)
                                  <div class="row">
                                      <div class="col-md-8">
                                          <input type="file" class="form-control form-control-sm" name="gambar">
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{Dits::imageUrl($data->gambar)}}" target="_blank" class="btn btn-info btn-sm btn-block">Lihat Gambar Sebelumnya</a>
                                        </div>
                                    </div>
                                    @else 
                                    <input type="file" class="form-control form-control-sm" name="gambar">
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{isset($edit) ? $data->a : ''}}" class="form-control form-control-sm" name="a">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{isset($edit) ? $data->b : ''}}" class="form-control form-control-sm" name="b">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{isset($edit) ? $data->c : ''}}" class="form-control form-control-sm" name="c">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{isset($edit) ? $data->d : ''}}" class="form-control form-control-sm" name="d">
                            </div>
                            <div class="form-group">
                                {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
                                <select class="form-control form-control-sm" name="kunci_jawaban" id="exampleFormControlSelect1">
                                  <option disabled selected>-Pilih Kunci Jawaban</option>
                                  <option {{isset($edit) ? Dits::selected($data->kunci_jawaban , 'a') : ''}}  value="a">A</option>
                                  <option {{isset($edit) ? Dits::selected($data->kunci_jawaban , 'b') : ''}} value="b">B</option>
                                  <option {{isset($edit) ? Dits::selected($data->kunci_jawaban , 'c') : ''}} value="c">C</option>
                                  <option {{isset($edit) ? Dits::selected($data->kunci_jawaban , 'd') : ''}} value="d">D</option>
                                </select>
                              </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-sm float-right" type="submit">Simpan</button>
                    {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-info btn-sm float-right mr-2">Kembali</a> --}}
                </div>
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
                // ['style', ['style']],
                ['font', ['bold', 'underline', 'clear' , 'italic']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['insert', ['link', 'picture', 'video']],
                // ['view', ['fullscreen']]
                ]
            });
        });
    </script>
@endpush
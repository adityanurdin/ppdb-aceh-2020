@extends('layouts.backend.index')

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('buka-ppdb.update_pengumuman' , $id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($data)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="mt-2">Kode Pendaftaran</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="mt-1">Status Diterima/Ditolak</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="mt-1">Jalur Diterima</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" value="{{isset($data) ? $data->kode_pendaftaran : ''}}" {{isset($data) ? 'readonly' : ''}} name="kode_pendaftaran" placeholder="Kode Pendaftaran" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="status_diterima" id="exampleFormControlSelect1">
                                        <option selected disabled>-Pilih Status</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="jalur_diterima" id="exampleFormControlSelect1">
                                        <option selected disabled>-Pilih Jalur Diterima</option>
                                        <option value="Tidak Diterima" style="color: red;">Tidak Diterima</option>
                                        <option value="Jalur Reguler">Jalur Reguler</option>
                                        <option value="Jalur Berprestasi">Jalur Berprestasi</option>
                                        <option value="Jalur Kedinasan">Jalur Kedinasan</option>
                                        <option value="Jalur Koni">Jalur KONI</option>
                                        <option value="Jalur Lainnya">Jalur Lainnya</option>
                                      </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
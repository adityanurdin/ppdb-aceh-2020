@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Buka PPDB</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Detail</a></li>
        <li class="bc-item active" aria-current="page">Pengumuman</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{route('buka-ppdb.update_pengumuman' , $id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- @isset($data) --}}
                    @method('PUT')
                    {{-- @endisset --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="mt-2">Kode Pendaftaran *</label>
                                <input type="text" value="{{isset($data) ? $data->kode_pendaftaran : ''}}"
                                    {{isset($data) ? 'readonly' : ''}} name="kode_pendaftaran"
                                    placeholder="Kode Pendaftaran" id="" class="form-control" autocomplete="off"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="" class="mt-1">Status Diterima/Ditolak *</label>
                                <select class="form-control" name="status_diterima" required>
                                    <option value="" selected disabled>-Pilih Status</option>
                                    <option {{Dits::selected(isset($data) ? $data->status_diterima : '', 'Diterima' )}}
                                        value="Diterima">Diterima</option>
                                    <option {{Dits::selected(isset($data) ? $data->status_diterima : '', 'Ditolak' )}}
                                        value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="mt-1">Jalur Diterima *</label>
                                <select class="form-control" name="jalur_diterima" required>
                                    <option value="" selected disabled>-Pilih Jalur Diterima</option>
                                    <option
                                        {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Tidak Diterima' )}}
                                        value="Tidak Diterima" style="color: red;">Tidak Diterima</option>
                                    <option
                                        {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Jalur Reguler' )}}
                                        value="Jalur Reguler">Jalur Reguler</option>
                                    <option
                                        {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Jalur Berprestasi' )}}
                                        value="Jalur Berprestasi">Jalur Berprestasi</option>
                                    <option
                                        {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Jalur Kedinasan' )}}
                                        value="Jalur Kedinasan">Jalur Kedinasan</option>
                                    <option {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Jalur Koni' )}}
                                        value="Jalur Koni">Jalur KONI</option>
                                    <option
                                        {{Dits::selected(isset($data) ? $data->jalur_diterima : '', 'Jalur Lainnya' )}}
                                        value="Jalur Lainnya">Jalur Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info float-right"><i class="fa fa-save"></i> SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
@endsection
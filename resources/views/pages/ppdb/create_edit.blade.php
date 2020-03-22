@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Buka PPDB</a></li>
        <li class="bc-item active" aria-current="page">Create / Edit</li>
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
                    action="{{ isset($data) ? route('buka-ppdb.update' , Dits::encodeDits($data->uuid)) : route('buka-ppdb.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($data)
                    @method('PUT')
                    @endisset
                    @if (Auth::user()->role != 'Operator Madrasah')
                    <div class="form-group">
                        <label for="">Pilih Madrasah *</label>
                        <select class="form-control @error('uuid_madrasah') is-invalid @enderror" required
                            name="uuid_madrasah" id="exampleFormControlSelect1">
                            <option value="" selected disabled>-Pilih Madrasah</option>
                            @if (isset($data))
                            @foreach ($madrasah as $item)
                            <option @if($data->uuid_madrasah == $item->uuid) selected @endif
                                value="{{Dits::encodeDits($item->uuid)}}">{{$item->nama_madrasah}}</option>
                            @endforeach
                            @else
                            @foreach ($madrasah_list as $item)
                            <option value="{{Dits::encodeDits($item->uuid)}}">{{$item->nama_madrasah}}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('uuid_madrasah')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">Tanggal Pembukaan *</label>
                        <div class='input-group date' id='tgl_pembukaan'>
                            <input type="text" name="tgl_pembukaan"
                                value="{{isset($data) ? date('d-m-Y',strtotime($data->tgl_pembukaan)) : ''}}"
                                placeholder="tgl-bln-thn"
                                class="form-control @error('tgl_pembukaan') is-invalid @enderror" maxlength="10"
                                autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                            @error('tgl_pembukaan')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Penutupan *</label>
                        <div class='input-group date' id='tgl_penutupan'>
                            <input type="text" name="tgl_penutupan"
                                value="{{isset($data) ? date('d-m-Y',strtotime($data->tgl_penutupan)) : ''}}"
                                placeholder="tgl-bln-thn"
                                class="form-control @error('tgl_penutupan') is-invalid @enderror" maxlength="10"
                                autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                            @error('tgl_penutupan')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Pengumuman *</label>
                        <div class='input-group date' id='tgl_pengumuman'>
                            <input type="text" name="tgl_pengumuman"
                                value="{{isset($data) ? date('d-m-Y',strtotime($data->tgl_pengumuman)) : ''}}"
                                placeholder="tgl-bln-thn"
                                class="form-control @error('tgl_pengumuman') is-invalid @enderror" maxlength="10"
                                autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                            @error('tgl_pengumuman')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tahun Akademik *</label>
                        <input type="text" name="tahun_akademik" value="{{isset($data) ? $data->tahun_akademik : ''}}"
                            id="" placeholder="Tahun Akademik"
                            class="form-control @error('tahun_akademik') is-invalid @enderror" maxlength="9"
                            autocomplete="off" required>
                        <small>Contoh: 2019/2020</small>
                        @error('tahun_akademik')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Status Penomoran *</label>
                        <select class="form-control @error('status_nomor') is-invalid @enderror" name="status_nomor"
                            id="" required>
                            <option {{Dits::selected(isset($data) ? $data->status_nomor : '', 'yes' )}} value="yes">
                                Aktif</option>
                            <option {{Dits::selected(isset($data) ? $data->status_nomor  : '', 'no' )}} value="no">Tidak
                            </option>
                        </select>
                        @error('status_nomor')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    @if (isset($data))
                    <div class="form-group">
                        <label for="">File Brosur</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="file" name="url_brosur" id=""
                                    class="form-control @error('url_brosur') is-invalid @enderror">
                                <small>File: PDF | Ukuran Maksimal: 300KB</small>
                                @error('url_brosur')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <a href="{{Dits::pdfViewer(asset($data->url_brosur))}}" target="_blank"
                                    class="btn btn-info btn-sm btn-block">Lihat Brosur</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="">File Brosur</label>
                        <input type="file" name="url_brosur" id=""
                            class="form-control @error('url_brosur') is-invalid @enderror">
                        <small>File: PDF | Ukuran Maksimal: 300KB</small>
                        @error('url_brosur')
                        <div class="invalid-feedback text-left">
                            <label>{{ $message }}</label>
                        </div>
                        @enderror
                    </div>
                    @endif
            </div>
            <button type="submit" class="btn btn-info float-right mt-3"><i class="fa fa-save"></i> SIMPAN</button>
            </form>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection
@push('script')
<script>
    {{--  $('#tgl_pembukaan').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#tgl_penutupan').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#tgl_pengumuman').datepicker({
        uiLibrary: 'bootstrap4'
    });  --}}
    
    $('#tgl_pembukaan').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    $('#tgl_penutupan').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    $('#tgl_pengumuman').datetimepicker({
        format: 'DD-MM-YYYY'
    });
</script>
@endpush
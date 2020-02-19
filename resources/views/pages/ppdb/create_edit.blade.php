@extends('layouts.backend.index')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($data) ? route('buka-ppdb.update' , Dits::encodeDits($data->uuid)) : route('buka-ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset
                <div class="row">

                        <div class="col-md-4">
                            @if (Auth::user()->role != 'Operator Madrasah')
                            <div class="form-group">
                                <label for="">Pilih Madrasah</label>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="">Tanggal Pembukaan</label>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Penutupan</label>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pengumuman</label>
                            </div>
                            <div class="form-group">
                                <label for="">Tahun Akademik</label>
                            </div>
                            <div class="form-group" style="margin-top: 45px">
                                <label for="">File Brosur</label>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            @if (Auth::user()->role != 'Operator Madrasah')
                            <div class="form-group">
                                <select class="form-control form-control-sm" required name="uuid_madrasah" id="exampleFormControlSelect1">
                                    <option value="" selected disabled>-Pilih Madrasah</option>
                                    @foreach ($madrasah_list as $item)
                                    <option value="{{Dits::encodeDits($item->uuid)}}" {{ isset($data) ? Dits::selected($item->nama_madrasah , $item->nama_madrasah) : '' }}>{{$item->nama_madrasah}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <input type="date" name="tgl_pembukaan" value="{{isset($data) ? $data->tgl_pembukaan : ''}}" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="date" name="tgl_penutupan" value="{{isset($data) ? $data->tgl_penutupan : ''}}" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="date" name="tgl_pengumuman" value="{{isset($data) ? $data->tgl_pengumuman : ''}}" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="text" name="tahun_akademik" value="{{isset($data) ? $data->tahun_akademik : ''}}" id="" placeholder="Tahun Akademik" class="form-control form-control-sm">
                                <small>Contoh: 2019/2020</small>
                            </div>
                            @if (isset($data))
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="file" name="url_brosur" id="" class="form-control form-control-sm">
                                            <small>File: PDF | Ukuran Maksimal: 300KB</small>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{Dits::pdfViewer(asset($data->url_brosur))}}" target="_blank" class="btn btn-info btn-sm btn-block">Lihat Brosur</a>
                                        </div>
                                    </div>
                                </div>
                            @else 
                            <div class="form-group">
                                <input type="file" name="url_brosur" id="" class="form-control form-control-sm">
                                <small>File: PDF | Ukuran Maksimal: 300KB</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info float-right mt-3">Simpan</button>
            </form>
        </div>
    </div>
@endsection
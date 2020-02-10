@extends('layouts.backend.index')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{route('buka-ppdb.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
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
                            <div class="form-group mt-2">
                                <label for="">File Brosur</label>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            @if (Auth::user()->role != 'Operator Madrasah')
                            <div class="form-group">
                                <select class="form-control form-control-sm" required name="uuid_madrasah" id="exampleFormControlSelect1">
                                    <option value="" selected disabled>-Pilih Madrasah</option>
                                    @foreach ($madrasah as $item)
                                    <option value="{{Dits::encodeDits($item->uuid)}}">{{$item->nama_madrasah}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <input type="date" name="tgl_pembukaan" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="date" name="tgl_penutupan" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="date" name="tgl_pengumuman" id="" placeholder="dd / mm / yyyy" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <input type="text" name="tahun_akademik" id="" placeholder="Tahun Akademik" class="form-control form-control-sm">
                                <small>Contoh: 2019/2020</small>
                            </div>
                            <div class="form-group">
                                <input type="file" name="url_brosur" id="" class="form-control form-control-sm">
                                <small>File: PDF | Ukuran Maksimal: 300KB</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info float-right mt-3">Simpan</button>
            </form>
        </div>
    </div>
@endsection
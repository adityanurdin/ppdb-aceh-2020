@extends('layouts.backend.index')

@section('css')
<style>
    .card-header {
        text-align: center;
        background-color: #009DDD;
        color: whitesmoke;
        font-weight: 600;
    }
    .image {
        width: 75%;
    }
    .text {
        color: black;
    }
    .link {
        color: blueviolet;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Dokumen Persyaratan
        </div>
        <div class="card-body">
            <form action="{{route('buka-ppdb.dokumen.store' , Dits::encodeDits($data->uuid_madrasah))}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Dokumen Persyaratan</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {{-- <input type="text" > --}}
                            <textarea name="persyaratan" id="" cols="30" rows="10" class="form-control form-control-sm">{{$madrasah->persyaratan}}</textarea>
                            <small>Pisahkan Dengan Tanda Koma (,) Setiap Persyaratan.</small>
                            <br>
                            <small>Contoh : Fotocopy Rapor Legalisir,Fotocopy Akte Kelahiran,Fotocopy KK</small>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info btn-sm float-right">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Preview Dokumen Persyaratan
        </div>
        <div class="card-body">
            Bawa Bukti Pendaftaran Ini Ke Madrasah Yang Dituju/Didaftar.
            Tanda Tangan Sebelum Menyerahkan Ke Panitia Pendaftaran.
            Bawa Kelengkapan Lainnya Seperti :
            @foreach ($persyaratan as $item)
                <br> > {{$item}}
            @endforeach
        </div>
    </div>
@endsection
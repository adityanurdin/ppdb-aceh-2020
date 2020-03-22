@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page"><a href="{{ route('buka-ppdb')}}">Buka PPDB</a></li>
        <li class="bc-item" aria-current="page"><a href="{{URL::previous()}}">Detail</a></li>
        <li class="bc-item active" aria-current="page">Dokumen Persyaratan</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header text-white bg-dark">
        <h4><i class="fas fa-link"></i> Dokumen Persyaratan</h4>
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
                        <textarea name="persyaratan" id="" cols="30" rows="10"
                            class="form-control form-control-sm">{{$madrasah->persyaratan}}</textarea>
                        <small>Pisahkan Dengan Tanda Koma (,) Setiap Persyaratan.</small>
                        <br>
                        <small>Contoh : Fotocopy Rapor Legalisir,Fotocopy Akte Kelahiran,Fotocopy KK</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-save"></i> SIMPAN</button>
        </form>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header text-white bg-success">
        <h4><i class="fa fa-list-ol"></i> Preview List Dokumen</h4>
    </div>
    <div class="card-body">
        Bawa Bukti Pendaftaran Ini Ke Madrasah Yang Dituju/Didaftar.
        Tanda Tangan Sebelum Menyerahkan Ke Panitia Pendaftaran.
        Bawa Kelengkapan Lainnya Seperti :
        @foreach ($persyaratan as $item)
        <br> <i class="fa fa-chevron-circle-right"></i> {{$item}}
        @endforeach
    </div>
</div>
@endsection
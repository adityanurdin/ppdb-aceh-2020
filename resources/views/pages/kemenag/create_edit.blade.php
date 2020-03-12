@extends('layouts.backend.index')

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
@endsection

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Menu Kemenag</li>
        <li class="bc-item" aria-current="page">Data Operator</li>
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
                            <form action="{{ isset($data) ? route('kemenag.update' , Dits::encodeDits($data->uuid)) : route('kemenag.store')}}" method="POST" enctype="multipart/form-data">
                                @isset($data)
                                    @method("PUT")
                                @endisset
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" value="{{isset($data) ? $data->nama_operator : ''}}" name="nama_operator" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">No Telepon</label>
                                    <input type="text" value="{{isset($data) ? $data->kontak_operator : ''}}" name="kontak_operator" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" value="{{isset($data) ? $data->email_operator : ''}}" name="email_operator" id="" class="form-control">
                                </div>
                                @isset($data)
                                <div class="form-group">
                                    <label for="">Password Lama</label>
                                    <input type="password" name="old_password" id="" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Password Baru</label>
                                    <input type="password"  name="password" id="" class="form-control">
                                </div>
                                @endisset

                                <button type="submit" class="btn btn-info btn-block">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
@endsection
@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Akun</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('auth.akun.update')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" value="{{ $user->operator->nama_operator }}" name="nama_operator" id=""
                                class="form-control  @error('nama_operator') is-invalid @enderror" autocomplete="off"
                                maxlength="100" required>
                            @error('nama_operator')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">No Telepon</label>
                            <input type="text" value="{{ $user->operator->kontak_operator }}" name="kontak_operator" id=""
                                class="form-control  @error('kontak_operator') is-invalid @enderror" autocomplete="off"
                                maxlength="30" required>
                            @error('kontak_operator')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" value="{{ $user->operator->email_operator }}" name="email_operator" id=""
                                class="form-control  @error('email_operator') is-invalid @enderror" autocomplete="off"
                                maxlength="100" required>
                            @error('email_operator')
                            <div class="invalid-feedback text-left">
                                <label>{{ $message }}</label>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-body alert alert-info">
                        <h6><i class="fa fa-info-circle"></i> Akun Login Anda, Isi Password Jika Ingin Di Ubah.</h6>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" readonly value="{{$user->username}}" id=""
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="password" name="password" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" name="password_baru" id="" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-save"></i> SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection
@extends('layouts.backend.index')

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <div class="card">
        <div class="card-body">
                    <form action="#">
                        @if ($user->role != 'Peserta')
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" value="{{$user->username}}" id="" class="form-control">
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="password" name="password" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" name="password_baru"id="" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-info btn-sm float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
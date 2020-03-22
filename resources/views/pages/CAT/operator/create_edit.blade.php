@extends('layouts.backend.index')

@section('breadchumb')
<nav aria-label="bc">
    <ol class="bc">
        <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="bc-item" aria-current="page">Bank Soal</li>
        <li class="bc-item active" aria-current="page">Create</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('bank-soal.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mt-2">
                                <label for="">Nama Madrasah *</label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            @if (Auth::user()->role == 'Admin System' || Auth::user()->role == 'Operator Kemenag')
                            <div class="form-group">
                                <select class="form-control @error('nama_madrasah') is-invalid @enderror"
                                    name="nama_madrasah" id="exampleFormControlSelect1">
                                    <option value="" disabled selected>-Pilih Madrasah</option>
                                    @foreach ($madrasah as $item)
                                    <option value="{{$item->nama_madrasah}}">{{$item->nama_madrasah}}</option>
                                    @endforeach
                                </select>
                                @error('nama_madrasah')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            @else
                            <div class="form-group">
                                <input type="text" name="nama_madrasah" value="{{$data->madrasah['nama_madrasah']}}"
                                    {{isset($data->madrasah['nama_madrasah']) ? 'readonly' : ''}}
                                    class="form-control @error('nama_madrasah') is-invalid @enderror" autocomplete="off"
                                    maxlength="100" required>
                                @error('nama_madrasah')
                                <div class="invalid-feedback text-left">
                                    <label>{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm float-right"><i class="fa fa-save"></i>
                        SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection
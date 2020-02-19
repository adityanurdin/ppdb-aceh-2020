@extends('layouts.backend.index')

@section('css')
    <style>
        .bg-custom {
            /* text-align: center; */
            background-color: #009DDD;
            color: white;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-8">
        <ul class="list-group">
          <li class="list-group-item bg-custom"><b>Konfirmasi Test</b></li>
          <li class="list-group-item">
            <b>Nama Peserta</b>
            <br>
            {{ $data->nama }}
          </li>
          <li class="list-group-item">
            <b>NIK</b>
            <br>
            {{ $data->NIK }}
          </li>
          <li class="list-group-item">
            <b>Email</b>
            <br>
            {{ $data->email }}
          </li>
          <li class="list-group-item">
            <b>Tanggal Test</b>
            <br>
            {{date('d-m-Y')}}
          </li>
        </ul>
      </div>
      <div class="col">
        <div class="alert alert-warning mt-3" role="alert">
          <i class="fas fa-exclamation-triangle"></i> TOMBOL MULAI hanya akan aktif apabila waktu sekarang sudah melewati waktu mulai test. Tekan tombol <b>F5</b> untuk merefresh halaman
        </div>
        <form action="{{route('cat.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" required name="kode_soal" class="form-control" placeholder="Kode Ujian">
                <input type="hidden" value="{{Carbon\Carbon::now()}}" name="start">
                <button type="submit" class="btn btn-block btn-danger mt-2">MULAI</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
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

@section('breadchumb')
<nav aria-label="bc">
  <ol class="bc">
    <li class="bc-item"><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
    <li class="bc-item active" aria-current="page">Ujian CAT</li>
  </ol>
</nav>
@endsection

@section('content')
<div class="container mt-3">
  <div class="table-responsive-sm">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-8">
        <ul class="list-group">
          <li class="list-group-item bg-custom"><b><i class="fa fa-user"></i> Konfirmasi Data Diri Anda</b></li>
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
          <i class="fas fa-exclamation-triangle"></i> Masukkan Kode Ujian sesuai dengan yang diberikan oleh panitia
          seleksi ppdb madrasah.
        </div>
        <form action="{{route('cat.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <input type="text" required name="kode_soal" class="form-control" placeholder="Kode Ujian"
              autocomplete="off">
            <input type="hidden" value="{{Carbon\Carbon::now()}}" name="start">
            <button type="submit" class="btn btn-block btn-danger mt-2"><i class="fa fa-play-circle"></i> MULAI</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
document.cookie = 'minutes; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
document.cookie = 'seconds; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
</script>
@endpush
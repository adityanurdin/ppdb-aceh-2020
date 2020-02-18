@extends('layouts.backend.index')

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
                                    <label for="">Nama Madrasah</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                @if (Auth::user()->role == 'Admin System' || Auth::user()->role == 'Operator Kemenag')
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                    </select>
                                  </div>
                                @else   
                                <div class="form-group">
                                    <input type="text" name="nama_madrasah" value="{{$data->madrasah['nama_madrasah']}}" {{isset($data->madrasah['nama_madrasah']) ? 'readonly' : ''}} class="form-control">
                                </div>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
@extends('layouts.backend.index')

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
@endsection

@section('css')
    <link href="{{asset('css/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .card-header {
            text-align: center;
            background-color: #009DDD;
            color: whitesmoke;
            font-weight: 600;
        }
    </style>
@endsection

@section('headers')
    @if (Auth::user()->role == 'Peserta')
        Data Peserta PPDB Madrasah Kota Banda Aceh

    @else
        Selamat Datang
    @endif
@endsection

@section('content')

    @if (Auth::user()->role == 'Peserta')
        
        @if ( Dits::DataPeserta()->status_aktif == 'no' )
            <div class="alert alert-danger text-center" role="alert">
                ISI DENGAN DATA YANG BENAR DAN VALID SESUAI DOKUMEN YANG LEGAL (KK/AKTE/IJAZAH)
                JIKA DIKETAHUI PEMALSUAN DATA SAAT DAFTAR ULANG (DITERIMA), MAKA AKAN DI DISKUALIFIKASI
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{route('update.peserta')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-md-auto">
                    <img src="{{Dits::imageUrl(Dits::DataPeserta()->pas_foto)}}" width="150px" height="200px" class="img-thumbnail">
                    <br>
                    <span class="btn btn-primary btn-file btn-block">
                        Pilih Foto<input type="file" name="pas_foto" autocomplete="off" {{ Dits::DataPeserta()->pas_foto ? '' : 'required' }}>
                    </span>
                        <a href="#" class="btn btn-danger btn-block {{Dits::DataPeserta()->pas_foto ? '' : 'disabled'}}">Hapus Foto</a>
                    </div>
                    <div class="col-sm align-self-center">
                    <hr class="d-lg-none">
                        <div class="form-group">
                        <label for="inputNama">Nama Lengkap Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" name="nama" value="{{Dits::DataPeserta()->nama ? Dits::DataPeserta()->nama : ''}}" id="inputNama" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                        <label for="inputNik">No. KTP/NIK Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" readonly name="NIK" value="{{Dits::DataPeserta()->NIK ? Dits::DataPeserta()->NIK : ''}}" id="inputNik" placeholder="123213432132" required>
                        <i class="text-danger"><small>Untuk Yang Belum Memiliki KTP, Maka Ambil NIK Anak Dari Kartu Keluarga (KK)</small></i>
                        </div>
                        <div class="form-group">
                        <label for="inputNisn">NISN<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" id="inputNisn" name="nisn" value="{{Dits::DataPeserta()->nisn ? Dits::DataPeserta()->nisn : ''}}" placeholder="999413233" required>
                        <small class="text-danger">(Untuk Pendaftar Jenjang MTs dan MA)</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label for="inputTL">Tempat Lahir Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" name="tmp" value="{{Dits::DataPeserta()->tmp ? Dits::DataPeserta()->tmp : ''}}" id="inputTL" placeholder="Contoh : Kota Banca Aceh" required>
                        </div>
                        <div class="form-group">
                        <label for="inputTTL">Tanggal Lahir Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="date" class="form-control" name="tgl" value="{{Dits::DataPeserta()->tgl ? Dits::DataPeserta()->tgl : ''}}" id="inputTTL" required>
                        </div>
                        <div class="form-group">
                        <label for="jk">Jenis Kelamin Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="jk" name="jkl">
                            <option selected disabled>Pilih Jenis Kelamin</option>
                            <option value="Laki - laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="agama">Agama Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option selected disabled>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Kong Hu Cu">Kong Hu Cu</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="hobi">Hobi Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="hobi" name="hobi" required>
                            <option selected disabled>Pilih Hobi</option>
                            <option value="Olahraga">Olahraga</option>
                                <option value="Kesenian">Kesenian</option>
                                <option value="Membaca">Membaca</option>
                                <option value="Menulis">Menulis</option>
                                <option value="Jalan - jalan">Jalan - jalan</option>
                                <option value="Lainnya">Lainnya</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="cita">Cita-Cita Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="cita" name="cita2" required>
                            <option selected disabled>Pilih Cita-Cita</option>
                            <option value="Lainnya">Lainnya</option>
                                <option value="PNS">PNS</option>
                                <option value="TNI/Polri">TNI/Polri</option>
                                <option value="Guru/Dosen">Guru/Dosen</option>
                                <option value="Dokter">Dokter</option>
                                <option value="Politikus">Politikus</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Ilmuan">Ilmuan</option>
                                <option value="Agamawan">Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="anak">Anak Ke-<i class="text-danger"><small>*</small></i></label>
                        <input type="number" value="{{Dits::DataPeserta()->anak_ke ? Dits::DataPeserta()->anak_ke : ''}}" class="form-control" name="anak_ke" id="anak" placeholder="Contoh : 1" required>
                        </div>
                        <div class="form-group">
                        <label for="jml_sdr">Jumlah Saudara<i class="text-danger"><small>*</small></i></label>
                        <input type="number" value="{{Dits::DataPeserta()->jml_saudara ? Dits::DataPeserta()->jml_saudara : ''}}" class="form-control" name="jml_saudara" id="jml_sdr" placeholder="Contoh : 2" required>
                        </div>
                        <div class="form-group">
                        <label for="alamat_rmh">Alamat Rumah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->alamat_rumah ? Dits::DataPeserta()->alamat_rumah : ''}}" id="alamat_rmh" name="alamat_rumah" placeholder="Jl. Makam Pahlawan, Rt/Rw. 03/08, No. 7" required>
                        </div>
                        <div class="form-group">
                        <label for="sklh_asl">Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="sklh_asl" name="sekolah_asal" required>
                            <option selected disabled>Pilih Sekolah Asal</option>
                            <option value="RA">RA</option>
                            <option value="TK">TK</option>
                            <option value="TKLB">TKLB</option>
                            <option value="PAUD">PAUD</option>
                            <option value="Langsung dari Orang Tua">Langsung dari Orang Tua</option>
                            <option value="Kelompok Bermain">Kelompok Bermain</option>
                            <option value="SD">SD</option>
                            <option value="SD Luar Negeri">SD Luar Negeri</option>
                            <option value="MI">MI</option>
                            <option value="Paket A">Paket A</option>
                            <option value="Paket B">Paket B</option>
                            <option value="SMP">SMP</option>
                            <option value="SMP Luar Negeri">SMP Luar Negeri</option>
                            <option value="MTs">MTs</option>
                            <option value="Pondok Pesantren">Pondok Pesantren</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="npsn">NPSN Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->npsn_sekolah_asal ? Dits::DataPeserta()->npsn_sekolah_asal : ''}}" name="npsn_sekolah_asal" id="number" placeholder="Contoh : 10212000" required>
                        </div>
                        <div class="form-group">
                        <label for="nm_sklh_asl">Nama Sekoah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->nama_sekolah_asal ? Dits::DataPeserta()->nama_sekolah_asal : ''}}" name="nama_sekolah_asal" id="nm_sklh_asl" placeholder="Contoh : SDN Cakrawala" required>
                        </div>
                        <div class="form-group">
                        <label for="almt_sklh_asl">Alamat Sekoah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->alamat_sekolah_asal ? Dits::DataPeserta()->alamat_sekolah_asal : ''}}" id="almt_sklh_asl" name="alamat_sekolah_asal" placeholder="Contoh : Jl. Cakrawala" required>
                        </div>
                        <div class="form-group">
                        <label for="prestasi">Prestasi Siswa</label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->jenis_prestasi ? Dits::DataPeserta()->jenis_prestasi : ''}}" id="prestasi" name="jenis_prestasi" placeholder="Contoh : Juara 1 Pencak Silat Nasional" required>
                        <small class="text-danger">Diisi Jika Memiliki Sertifikat Prestasi, Jika Lebih Dari 1, Pisahkan Dengan Koma (,)</small>
                        </div>
                        <div class="form-group">
                        <label for="stts_yp">Status Yatim Piatu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" name="yatim_piatu" id="stts_yp" required>
                            <option disabled selected>-Pilih Status Yatim Piatu</option>
                            <option value="Tidak">Tidak</option>
                            <option value="Yatim Piatu">Yatim Piatu</option>
                            <option value="Yatim">Yatim</option>
                            <option value="Piatu">Piatu</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="kp">Kartu Program</label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->kartu_program ? Dits::DataPeserta()->kartu_program : ''}}" name="kartu_program" id="kp" placeholder="Contoh : KIP">
                        <small class="text-danger">Diisi Jika Memiliki Kartu Program, Jika Lebih Dari 1, Pisahkan Dengan Koma (,)</small>
                        </div>
                        <div class="form-group">
                        <label for="nm_ayah">Nama Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->nama_ayah ? Dits::DataPeserta()->nama_ayah : ''}}" id="nm_ayah" name="nama_ayah" placeholder="Nama Ayah" required>
                        </div>
                        <div class="form-group">
                        <label for="ktp_ayah">No. KTP/NIK Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" value="{{Dits::DataPeserta()->nik_ayah ? Dits::DataPeserta()->nik_ayah : ''}}" id="ktp_ayah" name="nik_ayah" placeholder="Contoh : 3222206209020000" required>
                        </div>
                        <div class="form-group">
                        <label for="lhr_ayah">Tempat Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->tmp_ayah ? Dits::DataPeserta()->tmp_ayah : ''}}" id="lhr_ayah" name="tmp_ayah" placeholder="Contoh : Kota Banca Aceh" required>
                        </div>
                        <div class="form-group">
                        <label for="tgl_ayah">Tanggal Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="date" class="form-control" value="{{Dits::DataPeserta()->tgl_ayah ? Dits::DataPeserta()->tgl_ayah : ''}}" name="tgl_ayah" id="tgl_ayah" required>
                        </div>
                        <div class="form-group">
                        <label for="pkrj_ayah">Pekerjaan Ayah<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="stts_yp" name="pekerjaan_ayah" required>
                            <option selected disabled>Pilih Pekerjaan Ayah</option>
                            <option value="Lainnya">Lainnya</option>
                            <option value="PNS">PNS</option>
                            <option value="TNI/Polri">TNI/Polri</option>
                            <option value="Guru/Dosen">Guru/Dosen</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Politikus">Politikus</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Ilmuan">Ilmuan</option>
                            <option value="Agamawan">Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="nm_ibu">Nama Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" value="{{Dits::DataPeserta()->nama_ibu ? Dits::DataPeserta()->nama_ibu : ''}}" id="nm_ibu" name="nama_ibu" placeholder="Nama Ibu" required>
                        </div>
                        <div class="form-group">
                        <label for="ktp_ibu">No. KTP/NIK Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" value="{{Dits::DataPeserta()->nik_ibu ? Dits::DataPeserta()->nik_ibu : ''}}" id="ktp_ibu" name="nik_ibu" placeholder="Contoh : 3222206209020000" required>
                        </div>
                        <div class="form-group">
                        <label for="lhr_ibu">Tempat Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="lhr_ibu" value="{{Dits::DataPeserta()->tmp_ibu ? Dits::DataPeserta()->tmp_ibu : ''}}" name="tmp_ibu" placeholder="Contoh : Kota Banca Aceh" required>
                        </div>
                        <div class="form-group">
                        <label for="tgl_ibu">Tanggal Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="date" class="form-control" id="tgl_ibu" value="{{Dits::DataPeserta()->tgl_ibu ? Dits::DataPeserta()->tgl_ibu : ''}}" name="tgl_ibu" required>
                        </div>
                        <div class="form-group">
                        <label for="pkrj_ibu">Pekerjaan Ibu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="pkrj_ibu" name="pekerjaan_ibu" required>
                            <option selected disabled>Pilih Pekerjaan Ibu</option>
                            <option value="Lainnya">Lainnya</option>
                            <option value="PNS">PNS</option>
                            <option value="TNI/Polri">TNI/Polri</option>
                            <option value="Guru/Dosen">Guru/Dosen</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Politikus">Politikus</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Ilmuan">Ilmuan</option>
                            <option value="Agamawan">Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="kontak">Kontak Peserta<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" value="{{Dits::DataPeserta()->kontak_peserta ? Dits::DataPeserta()->kontak_peserta : ''}}" name="kontak_peserta" id="kontak" placeholder="Contoh : 08128888xxxx">
                        </div>
                        <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" class="form-control" value="{{Auth::user()->email}}" id="email" placeholder="contoh@email.com" readonly>
                        <small class="text-danger">Tidak Bisa Diedit, Email Akun Login</small>
                        </div>
                        <br>
                        <i>* : Wajib Diisi</i>
                        <br>
                        <button type="submit" class="btn btn-info btn-block">Ubah</button>
                        <br><br>
                    </div>
                </div>
            </form>
            </div>
        </div>

        @php
            $isUpdate = Dits::checkJenjang();
        @endphp
        @if ($isUpdate == 'MI')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: 5px;">
                            Fotocopy KK
                        </div>
                        <div class="form-group" style="margin-top: 70px;">
                            Fotocopy Akte
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="" id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                        <div class="form-group">
                            <input type="file" name="" id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($isUpdate == 'MTs')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: 5px;">
                            Fotocopy Raport Kelas 5 smt 1
                        </div>
                        <div class="form-group" style="margin-top: 70px;">
                            Fotocopy Raport Kelas 5 smt 2
                        </div>
                        <div class="form-group" style="margin-top: 65px;">
                            Fotocopy Raport Kelas 6 smt 1
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="" id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                        <div class="form-group">
                            <input type="file" name="" id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                        <div class="form-group">
                            <input type="file" name="" id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($isUpdate == 'MA')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: 5px;">
                            Fotocopy Raport Kelas 8 smt 1
                        </div>
                        <div class="form-group" style="margin-top: 70px;">
                            Fotocopy Raport Kelas 8 smt 2
                        </div>
                        <div class="form-group" style="margin-top: 65px;">
                            Fotocopy Raport Kelas 9 smt 1
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if (Dits::DataPeserta()->rapot_1 != '')
                        <div class="form-group">
                            <input type="text" value="Sudah Terupload" name="rapot_1" id="" class="form-control form-control-sm" disabled>
                            <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_1))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_1' , Dits::DataPeserta()->NIK])}}" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        </div>
                        @else
                        <form action="{{route('upload-document' , 'rapot_1')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="rapot_1" id="" required class="form-control form-control-sm">
                                <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                            </div>
                        </form>
                        @endif
                        @if (Dits::DataPeserta()->rapot_2 != '')
                        <div class="form-group">
                            <input type="text" value="Sudah Terupload" name="rapot_2" id="" class="form-control form-control-sm" disabled>
                            <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_2))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_2' , Dits::DataPeserta()->NIK])}}" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        </div>
                        @else
                        <form action="{{route('upload-document' , 'rapot_2')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <input type="file" name="rapot_2" id="" required class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                        </form>
                        @endif
                        @if (Dits::DataPeserta()->rapot_3 != '')
                        <div class="form-group">
                            <input type="text" value="Sudah Terupload" name="rapot_3" id="" class="form-control form-control-sm" disabled>
                            <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_3))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_3' , Dits::DataPeserta()->NIK])}}" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        </div>
                        @else
                        <form action="{{route('upload-document' , 'rapot_3')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <input type="file" name="rapot_3" id="" required class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else

        @endif

    @elseif (Auth::user()->role == 'Admin System')
        <div class="card">
            <div class="card-body">
                <img src="https://simppdbaceh.frandikasepta.com/assets/img/banner.png" width="100%" alt="        ">
            </div>
        </div>
    
    @elseif (Auth::user()->role == 'Operator Kemenag')
        <div class="card">
            <div class="card-body">
                <img src="https://simppdbaceh.frandikasepta.com/assets/img/banner.png" width="100%" alt="        ">
            </div>
        </div>

    @endif

@endsection
@push('script')
<script src="{{asset('js/gijgo.min.js')}}" type="text/javascript"></script>
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#datepicker3').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script>
@endpush
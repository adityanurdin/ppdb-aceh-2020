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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                        <a href="{{route('delete.photo.peserta')}}" onclick="return confirm_delete()" class="btn btn-danger btn-block {{Dits::DataPeserta()->pas_foto ? '' : 'disabled'}}">Hapus Foto</a>
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
                            <option {{Dits::selected(Dits::DataPeserta()->jkl , 'Laki - laki')}} value="Laki - laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="agama">Agama Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option selected disabled>Pilih Agama</option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Islam')}} value="Islam">Islam</option>
                                <option {{Dits::selected(Dits::DataPeserta()->agama , 'Kristen Protestan')}} value="Kristen Protestan">Kristen Protestan</option>
                                <option {{Dits::selected(Dits::DataPeserta()->agama , 'Katolik')}} value="Katolik">Katolik</option>
                                <option {{Dits::selected(Dits::DataPeserta()->agama , 'Hindu')}} value="Hindu">Hindu</option>
                                <option {{Dits::selected(Dits::DataPeserta()->agama , 'Buddha')}} value="Buddha">Buddha</option>
                                <option {{Dits::selected(Dits::DataPeserta()->agama , 'Kong Hu Cu')}} value="Kong Hu Cu">Kong Hu Cu</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="hobi">Hobi Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="hobi" name="hobi" required>
                            <option selected disabled>Pilih Hobi</option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Olahraga')}} value="Olahraga">Olahraga</option>
                                <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Kesenian')}} value="Kesenian">Kesenian</option>
                                <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Membaca')}} value="Membaca">Membaca</option>
                                <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Menulis')}} value="Menulis">Menulis</option>
                                <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Jalan - jalan')}} value="Jalan - jalan">Jalan - jalan</option>
                                <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Lainnya')}} value="Lainnya">Lainnya</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="cita">Cita-Cita Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="cita" name="cita2" required>
                            <option selected disabled>Pilih Cita-Cita</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Lainnya')}} value="Lainnya">Lainnya</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'PNS')}} value="PNS">PNS</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'TNI/Polri')}} value="TNI/Polri">TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Guru/Dosen')}} value="Guru/Dosen">Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Dokter')}} value="Dokter">Dokter</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Politikus')}} value="Politikus">Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Wiraswasta')}} value="Wiraswasta">Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Ilmuan')}} value="Ilmuan">Ilmuan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Agamawan')}} value="Agamawan">Agamawan</option>
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
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'RA')}} value="RA">RA</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'TK')}} value="TK">TK</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'TKLB')}} value="TKLB">TKLB</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'PAUD')}} value="PAUD">PAUD</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Langsung dari Orang Tua')}} value="Langsung dari Orang Tua">Langsung dari Orang Tua</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Kelompok Bermain')}} value="Kelompok Bermain">Kelompok Bermain</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SD')}} value="SD">SD</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SD Luar Negeri')}} value="SD Luar Negeri">SD Luar Negeri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'MI')}} value="MI">MI</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Paket A')}} value="Paket A">Paket A</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Paket B')}} value="Paket B">Paket B</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SMP')}} value="SMP">SMP</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SMP Luar Negeri')}} value="SMP Luar Negeri">SMP Luar Negeri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'MTs')}} value="MTs">MTs</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Pondok Pesantren')}} value="Pondok Pesantren">Pondok Pesantren</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Lainnya')}} value="Lainnya">Lainnya</option>
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
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Tidak')}} value="Tidak">Tidak</option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Yatim Piatu')}} value="Yatim Piatu">Yatim Piatu</option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Yatim')}} value="Yatim">Yatim</option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Piatu')}} value="Piatu">Piatu</option>
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
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Lainnya')}} value="Lainnya">Lainnya</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'PNS')}} value="PNS">PNS</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'TNI/Polri')}} value="TNI/Polri">TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Guru/Dosen')}} value="Guru/Dosen">Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Dokter')}} value="Dokter">Dokter</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Politikus')}} value="Politikus">Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Wiraswasta')}} value="Wiraswasta">Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Ilmuan')}} value="Ilmuan">Ilmuan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Agamawan')}} value="Agamawan">Agamawan</option>
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
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Lainnya')}} value="Lainnya">Lainnya</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'PNS')}} value="PNS">PNS</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'TNI/Polri')}} value="TNI/Polri">TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Guru/Dosen')}} value="Guru/Dosen">Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Dokter')}} value="Dokter">Dokter</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Politikus')}} value="Politikus">Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Wiraswasta')}} value="Wiraswasta">Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Ilmuan')}} value="Ilmuan">Ilmuan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Agamawan')}} value="Agamawan">Agamawan</option>
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
        {{-- MI --}}
        @if ($isUpdate == 'MI')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="table-resposive">
                    <div class="form-group">
                        @if (Dits::DataPeserta()->akte != '')
                        <label for="">
                            Fotocopy Akte Kelahiran
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->akte))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['akte' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'akte')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Akte Kelahiran
                            </label>
                            <input type="file" name="akte" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (Dits::DataPeserta()->kk != '')
                        <label for="">
                            Fotocopy Kartu Keluarga
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->kk))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['kk' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'kk')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Kartu Keluarga
                            </label>
                            <input type="file" name="kk" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- MTs --}}
        @elseif ($isUpdate == 'MTs')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_1 != '')
                        <label for="">
                            Fotocopy Raport Kelas 5 smt 1
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_1))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_1' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_1')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 5 smt 1
                            </label>
                            <input type="file" name="rapot_1" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_2 != '')
                        <label for="">
                            Fotocopy Raport Kelas 5 smt 1
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_2))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_2' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_2')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 5 smt 2
                            </label>
                            <input type="file" name="rapot_2" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_3 != '')
                        <label for="">
                            Fotocopy Raport Kelas 6 smt 1
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_3))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_3' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_3')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 6 smt 1
                            </label>
                            <input type="file" name="rapot_3" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- MA --}}
        @elseif($isUpdate == 'MA')
        <div class="card mt-5">
            <div class="card-header">
                File Dokumen Pendaftaran
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_1 != '')
                        <label for="">
                            Fotocopy Raport Kelas 8 smt 1
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_1))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_1' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_1')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 8 smt 1
                            </label>
                            <input type="file" name="rapot_1" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_2 != '')
                        <label for="">
                            Fotocopy Raport Kelas 8 smt 2
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_2))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_2' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_2')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 8 smt 2
                            </label>
                            <input type="file" name="rapot_2" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (Dits::DataPeserta()->rapot_3 != '')
                        <label for="">
                            Fotocopy Raport Kelas 9 smt 1
                        </label>
                        <a href="{{Dits::pdfViewer(asset(Dits::DataPeserta()->rapot_3))}}" target="_blank" class="btn btn-info btn-sm float-right mt-2 mb-3">Lihat File</a>
                            <a href="{{route('delete-document' , ['rapot_3' , Dits::DataPeserta()->NIK])}}" onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2">Hapus File</a>
                        @else 
                        <form action="{{route('upload-document' , 'rapot_3')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">
                                Fotocopy Raport Kelas 9 smt 1
                            </label>
                            <input type="file" name="rapot_3" required id="" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3">Upload</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else

        @endif

    @elseif (Auth::user()->role != 'Peserta')
        <div class="card">
            <div class="card-body">
                <img src="https://simppdbaceh.frandikasepta.com/assets/img/banner.png" width="100%" alt="">
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
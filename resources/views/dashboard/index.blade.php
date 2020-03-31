@extends('layouts.backend.index')

@section('css')
<style>
    .card-header {
        text-align: center;
        color: whitesmoke;
        font-weight: 600;
    }
</style>
@endsection

@section('headers')
@if (Auth::user()->role == 'Peserta')
<h4 class="text-uppercase"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
@else
<h4 class="text-uppercase"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
{{-- <h4 class="text-uppercase"><i class="fas fa-tachometer-alt"></i> Selamat Datang</h4> --}}
@endif
@endsection

@section('content')

@if (Auth::user()->role == 'Peserta')

{{-- @if ( Dits::DataPeserta()->status_aktif == 'no' ) --}}
<div class="alert alert-warning" role="alert">
    <h4><b><i class="fa fa-info-circle"></i> PERHATIAN!</b></h4>
    <ul>
        <li>ISI DENGAN DATA YANG BENAR DAN VALID SESUAI DOKUMEN YANG LEGAL (KK/AKTE/IJAZAH).</li>
        <li>JIKA DIKETAHUI PEMALSUAN DATA SAAT DAFTAR ULANG (DITERIMA), MAKA AKAN DI <b>DISKUALIFIKASI!</b>.</li>
        <li>SETELAH MENDAFTAR PADA MADRASAH PILIHAN ANDA, ANDA KEMBALI KE HALAMAN INI UNTUK UPLOAD FILE DOKUMEN
            PERSYARATAN.</li>
    </ul>
</div>
{{-- @endif --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="clearfix"></div>
<div class="card shadow mt-4">
    <div class="card-header bg-dark text-left">
        <h5><i class="fa fa-user-alt"></i> Data Diri Peserta</h5>
    </div>
    @if ( Dits::DataPeserta()->status_aktif != 'no' )
    <div class="p-3 text-md-right text-white" style="background: rgba(4,5,6,0.4)">
        Umur Anda Terhitung Sampai Dengan 1 Juli {{ date('Y') }} Adalah <b>{{ Dits::hitungUmurPerJuli() }}</b>
    </div>
    @endif
    <div class="card-body">
        <form action="{{route('update.peserta')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-auto text-center">
                    <img src="{{Dits::imageUrl(Dits::DataPeserta()->pas_foto)}}" width="150px" height="200px"
                        class="img-thumbnail mb-2">
                    <div class="py-2">
                        <button class="btn btn-primary btn-file btn-block">
                            <i class="fa fa-file-image"></i>
                            Pilih Foto
                            <input type="file" name="pas_foto" autocomplete="off"
                                {{ Dits::DataPeserta()->pas_foto ? '' : '' }}>
                        </button>
                    </div>
                    <div>
                        <a href="{{route('delete.photo.peserta')}}" onclick="return confirm('Hapus Pas Foto Anda?')"
                            class="btn btn-danger btn-block {{Dits::DataPeserta()->pas_foto ? '' : 'disabled'}}"><i
                                class="fa fa-trash"></i> Hapus
                            Foto</a>
                    </div>
                </div>
                <div class="col-sm align-self-center">
                    <hr class="d-lg-none">
                    <div class="form-group">
                        <label for="inputNama">Nama Lengkap Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" name="nama"
                            value="{{Dits::DataPeserta()->nama ? Dits::DataPeserta()->nama : ''}}" id="inputNama"
                            placeholder="Nama Lengkap" autocomplete="off" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="inputNik">No. KTP/NIK Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" readonly name="NIK"
                            value="{{Dits::DataPeserta()->NIK ? Dits::DataPeserta()->NIK : ''}}" id="inputNik"
                            placeholder="123213432132" autocomplete="off" maxlength="16" required>
                        <i class="text-danger"><small>Untuk Yang Belum Memiliki KTP, Maka Ambil NIK Anak Dari Kartu
                                Keluarga (KK)</small></i>
                        <small class="text-danger"> | NIK Tidak Bisa Diedit, Akun Login</small>
                    </div>
                    <div class="form-group">
                        <label for="inputNisn">NISN<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" id="inputNisn" name="nisn"
                            value="{{Dits::DataPeserta()->nisn ? Dits::DataPeserta()->nisn : ''}}"
                            placeholder="123456789" autocomplete="off" maxlength="10" required>
                        <small class="text-danger">(Untuk Pendaftar Jenjang MTs dan MA)</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="inputTL">Tempat Lahir Siswa<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" name="tmp"
                            value="{{Dits::DataPeserta()->tmp ? Dits::DataPeserta()->tmp : ''}}" id="inputTL"
                            placeholder="Contoh : Kota Banca Aceh" autocomplete="off" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir Siswa<i class="text-danger"><small>*</small></i></label>
                        <div class='input-group date' id='inputTTL'>
                            <input type="text" name="tgl"
                                value="{{Dits::DataPeserta()->tgl ? date('d-m-Y',strtotime(Dits::DataPeserta()->tgl)) : ''}}"
                                placeholder="tgl-bln-thn" class="form-control"
                                maxlength="10" autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="jk" name="jkl" required>
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option {{Dits::selected(Dits::DataPeserta()->jkl , 'Laki-laki')}} value="Laki-laki">
                                Laki-laki</option>
                            <option {{Dits::selected(Dits::DataPeserta()->jkl , 'Perempuan')}} value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="" selected disabled>Pilih Agama</option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Islam')}} value="Islam">Islam
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Kristen Protestan')}}
                                value="Kristen Protestan">Kristen Protestan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Katolik')}} value="Katolik">Katolik
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Hindu')}} value="Hindu">Hindu
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Buddha')}} value="Buddha">Buddha
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->agama , 'Kong Hu Cu')}} value="Kong Hu Cu">
                                Kong Hu Cu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hobi">Hobi Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="hobi" name="hobi" required>
                            <option value="" selected disabled>Pilih Hobi</option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Olahraga')}} value="Olahraga">Olahraga
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Kesenian')}} value="Kesenian">Kesenian
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Membaca')}} value="Membaca">Membaca
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Menulis')}} value="Menulis">Menulis
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Travelling')}}
                                value="Travelling">Travelling</option>
                            <option {{Dits::selected(Dits::DataPeserta()->hobi , 'Lainnya')}} value="Lainnya">Lainnya
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cita">Cita-Cita Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="cita" name="cita2" required>
                            <option value="" selected disabled>Pilih Cita-Cita</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'PNS')}} value="PNS">PNS</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'TNI/Polri')}} value="TNI/Polri">
                                TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Guru/Dosen')}} value="Guru/Dosen">
                                Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Dokter')}} value="Dokter">Dokter
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Politikus')}} value="Politikus">
                                Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Wiraswasta')}} value="Wiraswasta">
                                Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Ilmuan')}} value="Ilmuan">Ilmuan
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Agamawan')}} value="Agamawan">
                                Agamawan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->cita2 , 'Lainnya')}} value="Lainnya">Lainnya
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anak">Anak Ke-<i class="text-danger"><small>*</small></i></label>
                        <input type="number"
                            value="{{Dits::DataPeserta()->anak_ke ? Dits::DataPeserta()->anak_ke : ''}}"
                            class="form-control" name="anak_ke" id="anak" placeholder="Contoh : 1" autocomplete="off"
                            min="1" required>
                    </div>
                    <div class="form-group">
                        @php
                        if(Dits::DataPeserta()->jml_saudara==""){
                        $jml_saudara = "";
                        }else{
                        $jml_saudara = Dits::DataPeserta()->jml_saudara;
                        }
                        @endphp
                        <label for="jml_sdr">Jumlah Saudara<i class="text-danger"><small>*</small></i></label>
                        <input type="number" value="{{ $jml_saudara }}" class="form-control" name="jml_saudara"
                            id="jml_sdr" placeholder="Contoh : 2" autocomplete="off" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_rmh">Alamat Rumah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->alamat_rumah ? Dits::DataPeserta()->alamat_rumah : ''}}"
                            id="alamat_rmh" name="alamat_rumah" placeholder="Jl. Makam Pahlawan, Rt/Rw. 03/08, No. 7"
                            autocomplete="off" maxlength="300" required>
                    </div>
                    <div class="form-group">
                        <label for="sklh_asl">Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="sklh_asl" name="sekolah_asal" required>
                            <option value="" selected disabled>Pilih Sekolah Asal</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'RA')}} value="RA">RA</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'TK')}} value="TK">TK</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'TKLB')}} value="TKLB">TKLB
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'PAUD')}} value="PAUD">PAUD
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Langsung dari Orang Tua')}}
                                value="Langsung dari Orang Tua">Langsung dari Orang Tua</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Kelompok Bermain')}}
                                value="Kelompok Bermain">Kelompok Bermain</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SD')}} value="SD">SD</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SD Luar Negeri')}}
                                value="SD Luar Negeri">SD Luar Negeri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'MI')}} value="MI">MI</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Paket A')}} value="Paket A">
                                Paket A</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Paket B')}} value="Paket B">
                                Paket B</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SMP')}} value="SMP">SMP
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'SMP Luar Negeri')}}
                                value="SMP Luar Negeri">SMP Luar Negeri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'MTs')}} value="MTs">MTs
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Pondok Pesantren')}}
                                value="Pondok Pesantren">Pondok Pesantren</option>
                            <option {{Dits::selected(Dits::DataPeserta()->sekolah_asal , 'Lainnya')}} value="Lainnya">
                                Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="npsn">NPSN Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->npsn_sekolah_asal ? Dits::DataPeserta()->npsn_sekolah_asal : ''}}"
                            name="npsn_sekolah_asal" id="number" placeholder="Contoh : 10212000" autocomplete="off"
                            maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="nm_sklh_asl">Nama Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->nama_sekolah_asal ? Dits::DataPeserta()->nama_sekolah_asal : ''}}"
                            name="nama_sekolah_asal" id="nm_sklh_asl" placeholder="Contoh : SDN Cakrawala"
                            autocomplete="off" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="almt_sklh_asl">Alamat Sekoah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->alamat_sekolah_asal ? Dits::DataPeserta()->alamat_sekolah_asal : ''}}"
                            id="almt_sklh_asl" name="alamat_sekolah_asal" placeholder="Contoh : Jl. Cakrawala"
                            autocomplete="off" maxlength="300" required>
                    </div>
                    <div class="form-group">
                        <label for="prestasi">Prestasi Siswa</label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->jenis_prestasi ? Dits::DataPeserta()->jenis_prestasi : ''}}"
                            id="prestasi" name="jenis_prestasi" placeholder="Contoh : Juara 1 Pencak Silat Nasional"
                            autocomplete="off" maxlength="300" required>
                        <small class="text-danger">Diisi Jika Memiliki Sertifikat Prestasi, Jika Lebih Dari 1, Pisahkan
                            Dengan Koma (,)</small>
                    </div>
                    <div class="form-group">
                        <label for="stts_yp">Status Yatim Piatu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" name="yatim_piatu" id="stts_yp" required>
                            <option value="" disabled selected>-Pilih Status Yatim Piatu</option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Tidak')}} value="Tidak">Tidak
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Yatim Piatu')}}
                                value="Yatim Piatu">Yatim Piatu</option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Yatim')}} value="Yatim">Yatim
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->yatim_piatu , 'Piatu')}} value="Piatu">Piatu
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kp">Kartu Program</label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->kartu_program ? Dits::DataPeserta()->kartu_program : ''}}"
                            name="kartu_program" id="kp" placeholder="Contoh : KIP" autocomplete="off" maxlength="100">
                        <small class="text-danger">Diisi Jika Memiliki Kartu Program, Jika Lebih Dari 1, Pisahkan Dengan
                            Koma (,)</small>
                    </div>
                    <div class="form-group">
                        <label for="nm_ayah">Nama Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->nama_ayah ? Dits::DataPeserta()->nama_ayah : ''}}"
                            id="nm_ayah" name="nama_ayah" placeholder="Nama Ayah" autocomplete="off" maxlength="100"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="ktp_ayah">No. KTP/NIK Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control"
                            value="{{Dits::DataPeserta()->nik_ayah ? Dits::DataPeserta()->nik_ayah : ''}}" id="ktp_ayah"
                            name="nik_ayah" placeholder="Contoh : 3222206209020000" autocomplete="off" maxlength="16"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="lhr_ayah">Tempat Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->tmp_ayah ? Dits::DataPeserta()->tmp_ayah : ''}}" id="lhr_ayah"
                            name="tmp_ayah" placeholder="Contoh : Kota Banca Aceh" autocomplete="off" maxlength="100"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <div class='input-group date' id='tgl_ayah'>
                            <input type="text" name="tgl_ayah"
                                value="{{Dits::DataPeserta()->tgl_ayah ? date('d-m-Y',strtotime(Dits::DataPeserta()->tgl_ayah)) : ''}}"
                                placeholder="tgl-bln-thn" class="form-control"
                                maxlength="10" autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pkrj_ayah">Pekerjaan Ayah<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="stts_yp" name="pekerjaan_ayah" required>
                            <option value="" selected disabled>Pilih Pekerjaan Ayah</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'PNS')}} value="PNS">PNS
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'TNI/Polri')}}
                                value="TNI/Polri">TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Guru/Dosen')}}
                                value="Guru/Dosen">Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Dokter')}} value="Dokter">
                                Dokter</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Politikus')}}
                                value="Politikus">Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Wiraswasta')}}
                                value="Wiraswasta">Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Ilmuan')}} value="Ilmuan">
                                Ilmuan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Agamawan')}}
                                value="Agamawan">Agamawan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ayah , 'Lainnya')}} value="Lainnya">
                                Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nm_ibu">Nama Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control"
                            value="{{Dits::DataPeserta()->nama_ibu ? Dits::DataPeserta()->nama_ibu : ''}}" id="nm_ibu"
                            name="nama_ibu" placeholder="Nama Ibu" autocomplete="off" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="ktp_ibu">No. KTP/NIK Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control"
                            value="{{Dits::DataPeserta()->nik_ibu ? Dits::DataPeserta()->nik_ibu : ''}}" id="ktp_ibu"
                            name="nik_ibu" placeholder="Contoh : 3222206209020000" autocomplete="off" maxlength="16"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="lhr_ibu">Tempat Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="lhr_ibu"
                            value="{{Dits::DataPeserta()->tmp_ibu ? Dits::DataPeserta()->tmp_ibu : ''}}" name="tmp_ibu"
                            placeholder="Contoh : Kota Banca Aceh" autocomplete="off" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <div class='input-group date' id='tgl_ibu'>
                            <input type="text" name="tgl_ibu"
                                value="{{Dits::DataPeserta()->tgl_ibu ? date('d-m-Y',strtotime(Dits::DataPeserta()->tgl_ibu)) : ''}}"
                                placeholder="tgl-bln-thn" class="form-control"
                                maxlength="10" autocomplete="off" required>
                            <span class="input-group-addon">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar-alt"></i>
                                    CARI</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pkrj_ibu">Pekerjaan Ibu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="pkrj_ibu" name="pekerjaan_ibu" required>
                            <option value="" selected disabled>Pilih Pekerjaan Ibu</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'PNS')}} value="PNS">PNS
                            </option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'TNI/Polri')}}
                                value="TNI/Polri">TNI/Polri</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Guru/Dosen')}}
                                value="Guru/Dosen">Guru/Dosen</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Dokter')}} value="Dokter">
                                Dokter</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Politikus')}}
                                value="Politikus">Politikus</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Wiraswasta')}}
                                value="Wiraswasta">Wiraswasta</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Ilmuan')}} value="Ilmuan">
                                Ilmuan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Agamawan')}}
                                value="Agamawan">Agamawan</option>
                            <option {{Dits::selected(Dits::DataPeserta()->pekerjaan_ibu , 'Lainnya')}} value="Lainnya">
                                Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kontak">Kontak Peserta<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control"
                            value="{{Dits::DataPeserta()->kontak_peserta ? Dits::DataPeserta()->kontak_peserta : ''}}"
                            name="kontak_peserta" id="kontak" placeholder="Contoh : 08128888xxxx" autocomplete="off"
                            maxlength="30" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" class="form-control" value="{{Auth::user()->email}}" id="email" name="email"
                            placeholder="contoh@email.com" autocomplete="off" maxlength="100" required>
                    </div>
                    <br>
                    <i>* : Wajib Diisi</i>
                    <br>
                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-save"></i> UBAH</button>
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
<div class="card mt-5 shadow">
    <div class="card-header bg-dark text-left">
        <h5><i class="fa fa-file-pdf"></i> File Dokumen Persyaratan</h5>
    </div>
    <div class="card-body">
        <div class="table-resposive">
            <div class="form-group">
                @if (Dits::DataPeserta()->akte != '')
                <label for="">
                    Scan Akte Kelahiran
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->akte)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['akte' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'akte')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Akte Kelahiran
                    </label>
                    <div class="py-2">
                        <input type="file" name="akte" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="form-group">
                @if (Dits::DataPeserta()->kk != '')
                <label for="">
                    Scan Kartu Keluarga
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->kk)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['kk' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'kk')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Kartu Keluarga
                    </label>
                    <div class="py-2">
                        <input type="file" name="kk" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- MTs --}}
@elseif ($isUpdate == 'MTs')
<div class="card mt-5 shadow">
    <div class="card-header bg-dark text-left">
        <h5><i class="fa fa-file-pdf"></i> File Dokumen Persyaratan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_1 != '')
                <label for="">
                    Scan Raport Kelas 5 smt 1
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_1)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_1' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_1')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 5 smt 1
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_1" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_2 != '')
                <label for="">
                    Scan Raport Kelas 5 smt 1
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_2)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_2' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_2')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 5 smt 2
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_2" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_3 != '')
                <label for="">
                    Scan Raport Kelas 6 smt 1
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_3)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_3' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_3')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 6 smt 1
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_3" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- MA --}}
@elseif($isUpdate == 'MA')
<div class="card mt-5 shadow">
    <div class="card-header bg-dark text-left">
        <h5><i class="fa fa-file-pdf"></i> File Dokumen Persyaratan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_1 != '')
                <label for="">
                    Scan Raport Kelas 8 smt 1
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_1)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_1' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_1')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 8 smt 1
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_1" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_2 != '')
                <label for="">
                    Scan Raport Kelas 8 smt 2
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_2)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_2' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_2')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 8 smt 2
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_2" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="form-group">
                @if (Dits::DataPeserta()->rapot_3 != '')
                <label for="">
                    Scan Raport Kelas 9 smt 1
                </label>
                <div class="py-2">
                    <a href="{{asset('storage/'.Dits::DataPeserta()->rapot_3)}}" target="_blank"
                        class="btn btn-info btn-sm float-right mt-2 mb-3"><i class="fa fa-eye"></i> Lihat File</a>
                    <a href="{{route('delete-document' , ['rapot_3' , Dits::DataPeserta()->NIK])}}"
                        onclick="return confirm_delete()" class="btn btn-danger btn-sm float-right mt-2 mb-3 mr-2"><i
                            class="fa fa-trash"></i> Hapus
                        File</a>
                </div>
                @else
                <form action="{{route('upload-document' , 'rapot_3')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">
                        Scan Raport Kelas 9 smt 1
                    </label>
                    <div class="py-2">
                        <input type="file" name="rapot_3" required id="" class="form-control form-control-sm">
                        <button type="submit" class="btn btn-info btn-sm float-right mt-2 mb-3"><i
                                class="fa fa-upload"></i>
                            UPLOAD</button>
                    </div>
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
        <img src="{{ asset('img/banner-min.png') }}" width="100%" alt="">
    </div>
</div>

@endif

@endsection
@push('script')
<script>
    $('#inputTTL').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            up: "fa fa-chevron-circle-up",
            down: "fa fa-chevron-circle-down",
            next: 'fa fa-chevron-circle-right',
            previous: 'fa fa-chevron-circle-left'
        }
    });
    $('#tgl_ayah').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            up: "fa fa-chevron-circle-up",
            down: "fa fa-chevron-circle-down",
            next: 'fa fa-chevron-circle-right',
            previous: 'fa fa-chevron-circle-left'
        }
    });
    $('#tgl_ibu').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            up: "fa fa-chevron-circle-up",
            down: "fa fa-chevron-circle-down",
            next: 'fa fa-chevron-circle-right',
            previous: 'fa fa-chevron-circle-left'
        }
    });
</script>
@endpush
@extends('layouts.backend.index')

@section('title')
   {{ strtoupper(isset(Dits::DataPeserta()->nama)) ? Dits::DataPeserta()->nama : Auth::user()->role }} - SIM PPDB Madrasah Kota Banda Aceh
@endsection

@section('css')
    <link href="{{asset('css/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
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
                <div class="row">
                    {{-- <form> --}}
                    <div class="col-md-auto">
                    <img src="{{Dits::imageUrl(Dits::DataPeserta()->pas_foto)}}" width="150px" height="200px" class="img-thumbnail">
                    <br>
                    <span class="btn btn-primary btn-file btn-block">
                        {{-- Upload Foto <input type="file"> --}}
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
                        <input type="number" class="form-control" name="NIK" value="{{Dits::DataPeserta()->NIK ? Dits::DataPeserta()->NIK : ''}}" id="inputNik" placeholder="123213432132" required>
                        <i class="text-danger"><small>Untuk Yang Belum Memiliki KTP, Maka Ambil NIK Anak Dari Kartu Keluarga (KK)</small></i>
                        </div>
                        <div class="form-group">
                        <label for="inputNisn">NISN<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="number" class="form-control" id="inputNisn" name="nisn" value="{{Dits::DataPeserta()->nisn ? Dits::DataPeserta()->nisn : ''}}" placeholder="999413233" required>
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
                            <option value="Laki - laki" {{Dits::DataPeserta()->jkl == 'Laki - laki' ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="Perempuan" {{Dits::DataPeserta()->jkl == 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="agama">Agama Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="agama" required>
                            <option selected disabled>Pilih Agama</option>
                            <option>Islam</option>
                            <option>Kristen Protestan</option>
                            <option>Katolik</option>
                            <option>Hindu</option>
                            <option>Budha</option>
                            <option>Kong Hu Chu</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="hobi">Hobi Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="hobi" required>
                            <option selected disabled>Pilih Hobi</option>
                            <option>Olahraga</option>
                            <option>Kesenian</option>
                            <option>Membaca</option>
                            <option>Menulis</option>
                            <option>Jalan-Jalan</option>
                            <option>Lainnya</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="cita">Cita-Cita Siswa<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="cita" required>
                            <option selected disabled>Pilih Cita-Cita</option>
                            <option>PNS</option>
                            <option>TNI/Polri</option>
                            <option>Guru/Dosen</option>
                            <option>Dokter</option>
                            <option>Politikus</option>
                            <option>Wiraswasta</option>
                            <option>Seniman/Artis</option>
                            <option>Ilmuwan</option>
                            <option>Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="anak">Anak Ke-<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" id="anak" placeholder="Contoh : 1" required>
                        </div>
                        <div class="form-group">
                        <label for="jml_sdr">Jumlah Saudara<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" id="jml_sdr" placeholder="Contoh : 2" required>
                        </div>
                        <div class="form-group">
                        <label for="alamat_rmh">Alamat Rumah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="alamat_rmh" placeholder="Jl. Makam Pahlawan, Rt/Rw. 03/08, No. 7" required>
                        </div>
                        <div class="form-group">
                        <label for="sklh_asl">Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="sklh_asl" required>
                            <option selected disabled>Pilih Sekolah Asal</option>
                            <option>RA</option>
                            <option>TK</option>
                            <option>TKLB</option>
                            <option>PAUD</option>
                            <option>Langsung Dari Orang Tua</option>
                            <option>Kelompok Bermain</option>
                            <option>SD</option>
                            <option>SD Luar Negeri</option>
                            <option>MI</option>
                            <option>Paket A</option>
                            <option>Paket B</option>
                            <option>SMP</option>
                            <option>SMP Luar Negeri</option>
                            <option>MTs</option>
                            <option>Pondok Pesantren</option>
                            <option>Lainnya</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="npsn">NPSN Sekolah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="number" class="form-control" id="number" placeholder="Contoh : 10212000" required>
                        </div>
                        <div class="form-group">
                        <label for="nm_sklh_asl">Nama Sekoah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" id="nm_sklh_asl" placeholder="Contoh : SDN Cakrawala" required>
                        </div>
                        <div class="form-group">
                        <label for="almt_sklh_asl">Alamat Sekoah Asal<i class="text-danger"><small>*</small></i></label>
                        <small class="text-danger">Jika Tidak Ada Isi Dengan Strip (-)</small>
                        <input type="text" class="form-control" id="almt_sklh_asl" placeholder="Contoh : Jl. Cakrawala" required>
                        </div>
                        <div class="form-group">
                        <label for="prestasi">Prestasi Siswa</label>
                        <input type="text" class="form-control" id="prestasi" placeholder="Contoh : Juara 1 Pencak Silat Nasional" required>
                        <small class="text-danger">Diisi Jika Memiliki Sertifikat Prestasi, Jika Lebih Dari 1, Pisahkan Dengan Koma (,)</small>
                        </div>
                        <div class="form-group">
                        <label for="stts_yp">Status Yatim Piatu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="stts_yp" required>
                            <option selected>Tidak</option>
                            <option>Yatim</option>
                            <option>Piatu</option>
                            <option>Yatim Piatu</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="kp">Kartu Program</label>
                        <input type="text" class="form-control" id="kp" placeholder="Contoh : KIP">
                        <small class="text-danger">Diisi Jika Memiliki Kartu Program, Jika Lebih Dari 1, Pisahkan Dengan Koma (,)</small>
                        </div>
                        <div class="form-group">
                        <label for="nm_ayah">Nama Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="nm_ayah" placeholder="Nama Ayah" required>
                        </div>
                        <div class="form-group">
                        <label for="ktp_ayah">No. KTP/NIK Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" id="ktp_ayah" placeholder="Contoh : 3222206209020000" required>
                        </div>
                        <div class="form-group">
                        <label for="lhr_ayah">Tempat Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="lhr_ayah" placeholder="Contoh : Kota Banca Aceh" required>
                        </div>
                        <div class="form-group">
                        <label for="tgl_ayah">Tanggal Lahir Ayah<i class="text-danger"><small>*</small></i></label>
                        <input type="date" class="form-control" id="tgl_ayah" required>
                        </div>
                        <div class="form-group">
                        <label for="pkrj_ayah">Pekerjaan Ayah<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="stts_yp" required>
                            <option selected disabled>Pilih Pekerjaan Ayah</option>
                            <option>Lainnya</option>
                            <option>PNS</option>
                            <option>TNI/Polri</option>
                            <option>Guru/Dosen</option>
                            <option>Dokter</option>
                            <option>Politikus</option>
                            <option>Wiraswasta</option>
                            <option>Seniman/Artis</option>
                            <option>Ilmuwan</option>
                            <option>Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="nm_ibu">Nama Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="nm_ibu" placeholder="Nama Ibu" required>
                        </div>
                        <div class="form-group">
                        <label for="ktp_ibu">No. KTP/NIK Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" id="ktp_ibu" placeholder="Contoh : 3222206209020000" required>
                        </div>
                        <div class="form-group">
                        <label for="lhr_ibu">Tempat Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="text" class="form-control" id="lhr_ibu" placeholder="Contoh : Kota Banca Aceh" required>
                        </div>
                        <div class="form-group">
                        <label for="tgl_ibu">Tanggal Lahir Ibu<i class="text-danger"><small>*</small></i></label>
                        <input type="date" class="form-control" id="tgl_ibu" required>
                        </div>
                        <div class="form-group">
                        <label for="pkrj_ibu">Pekerjaan Ibu<i class="text-danger"><small>*</small></i></label>
                        <select class="form-control" id="pkrj_ibu" required>
                            <option selected disabled>Pilih Pekerjaan Ibu</option>
                            <option>Lainnya</option>
                            <option>PNS</option>
                            <option>TNI/Polri</option>
                            <option>Guru/Dosen</option>
                            <option>Dokter</option>
                            <option>Politikus</option>
                            <option>Wiraswasta</option>
                            <option>Seniman/Artis</option>
                            <option>Ilmuwan</option>
                            <option>Agamawan</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="kontak">Kontak Peserta<i class="text-danger"><small>*</small></i></label>
                        <input type="number" class="form-control" id="kontak" placeholder="Contoh : 08128888xxxx">
                        </div>
                        <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" class="form-control" id="email" placeholder="contoh@email.com" disabled>
                        <small class="text-danger">Tidak Bisa Diedit, Email Akun Login</small>
                        </div>
                        <br>
                        <i>* : Wajib Diisi</i>
                        <br>
                        <button type="submit" class="btn btn-info btn-block">Ubah</button>
                        <br><br>
                    </div>
                {{-- </form> --}}
                </div>
            </div>
        </div>

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
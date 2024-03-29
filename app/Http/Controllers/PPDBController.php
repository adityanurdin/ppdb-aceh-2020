<?php

namespace App\Http\Controllers;

use App\Models\Madrasah;
use App\Models\Operator;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Auth;
use Carbon\Carbon;
use DataTables;
use DateTime;
use Dits;
use Illuminate\Http\Request;
use Str;
use Validator;
use Storage;
use Image;

class PPDBController extends Controller
{
    public function listByID($id)
    {
        return view('pages.ppdb.list', compact('id'));
    }

    public function bukaPPDB()
    {
        return view('pages.ppdb.buka-ppdb');
    }

    public function create()
    {
        $madrasah = Madrasah::all();
        $madrasah_list = Madrasah::whereNotIn('uuid', function ($query) {
            $query->select('uuid_madrasah')->from('pembukaans')->where('status_pembukaan', 'Dibuka');
        })->orderBy('nama_madrasah', 'ASC')->get();
        return view('pages.ppdb.create_edit', compact('madrasah', 'madrasah_list'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'tgl_pembukaan' => 'required|string|max:10',
            'tgl_penutupan' => 'required|string|max:10',
            'tgl_pengumuman' => 'required|string|max:10',
            'tahun_akademik' => 'required|string|max:9',
            'status_nomor' => 'required|max:3',
        ]);

        $user = Auth::user();
        $input = $request->all();
        if (!isset($request->uuid_madrasah)) {
            $operator = Operator::whereUuid($user->uuid_login)->first();
            $uuid_madrasah = $operator->uuid_madrasah;
        } else {
            $uuid_madrasah = Dits::decodeDits($request->uuid_madrasah);
            $operator = Operator::whereUuidMadrasah($uuid_madrasah)->first();
            if (is_null($operator)) {
                toast('Gagal, Madrasah Yang Di Pilih Belum Mempunyai Operator', 'error');
                return back();
            }
        }
        $madrasah = Madrasah::whereUuid($uuid_madrasah)
            ->first();
        $pembukaan = Pembukaan::whereUuidMadrasah($uuid_madrasah)
            ->where('status_pembukaan', 'Dibuka')
            ->first();
        if ($pembukaan != null) {
            toast('Gagal, Madrasah Yang Di Pilih Sedang Dibuka', 'error');
            return back();
        }

        $tgl_pembukaan = date('Y-m-d', strtotime($request->tgl_pembukaan));
        $tgl_penutupan = date('Y-m-d', strtotime($request->tgl_penutupan));
        $tgl_pengumuman = date('Y-m-d', strtotime($request->tgl_pengumuman));
        $thn = date('Y');

        $tahunpembukaan = date('Y', strtotime($tgl_pembukaan));
        $tahunpenutupan = date('Y', strtotime($tgl_penutupan));
        $tahunpengumuman = date('Y', strtotime($tgl_pengumuman));

        if ($tahunpembukaan != $thn || $tahunpenutupan != $thn || $tahunpengumuman != $thn) {
            toast('Gagal, Kesalahan Pemilihan Tahun!', 'error');
            return back();
        }

        if ($tgl_penutupan <= $tgl_pembukaan || $tgl_pengumuman <= $tgl_penutupan || $tgl_pengumuman <= $tgl_pembukaan) {
            toast('Gagal, Pengaturan Tanggal Pembukaan, Penutupan, dan Pengumunan Tidak Benar!', 'error');
            return back();
        }

        $valid = Validator::make($request->all(), [
            'url_brosur' => 'file|mimes:pdf|max:1000',
        ]);

        if ($valid->fails()) {
            toast('Gagal, File brosur tidak sesuai', 'error');
            return back();
        }

        $input = [
            'uuid' => Str::uuid(),
            'uuid_madrasah' => $uuid_madrasah,
            'uuid_operator' => $operator->uuid,
            'status_nomor' => 'yes',
            'tgl_post' => Carbon::now(),
            'url_brosur' => '',
            'status_pembukaan' => 'Dibuka',
            'tgl_pembukaan' => $tgl_pembukaan,
            'tgl_penutupan' => $tgl_penutupan,
            'tgl_pengumuman' => $tgl_pengumuman,
            'tahun_akademik' => $request->tahun_akademik,
        ];

        if ($request->hasFile('url_brosur')) {
            // Upload File
            $ext = strtolower($request->file('url_brosur')->extension());
            $ext_array = Array('pdf');
            if (in_array($ext, $ext_array)){
                $file = $request->file('url_brosur');
                $pat_brosur = 'brosur/'.date('Y').'/';
                $file_name = Str::slug($madrasah->nama_madrasah,'-');
                $file_name = $file_name."-".rand(1000,9999999999).".".$ext;
                $file_save = $pat_brosur.$file_name;
                if(!is_dir(storage_path('app/public/'.$pat_brosur))){
                    Storage::disk('public')->makeDirectory($pat_brosur);
                }
                Storage::disk('public')->putFileAs($pat_brosur,$file,$file_name);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
            $input['url_brosur'] = $file_save;
        }

        $create = Pembukaan::create($input);

        if ($create) {
            toast('Berhasil Membuat PPDB', 'success');
            return redirect()->route('buka-ppdb');
        }
        toast('Gagal, Membuat PPDB', 'error');
        return back();
    }

    public function edit($id)
    {
        $uuid = Dits::decodeDits($id);
        $madrasah = Madrasah::all();
        $madrasah_list = Madrasah::whereNotIn('uuid', function ($query) {
            $query->select('uuid_madrasah')->from('pembukaans')->where('status_pembukaan', 'Dibuka');
        })
            ->get();
        $data = Pembukaan::where('uuid', $uuid)->first();
        return view('pages.ppdb.create_edit', compact('madrasah', 'madrasah_list', 'data'));
    }

    public function update(Request $request, $id)
    {

        // Validation
        $request->validate([
            'uuid_madrasah' => 'required|string|max:100',
            'tgl_pembukaan' => 'required|string|max:10',
            'tgl_penutupan' => 'required|string|max:10',
            'tgl_pengumuman' => 'required|string|max:10',
            'tahun_akademik' => 'required|string|max:9',
            'status_nomor' => 'required|max:3',
        ]);

        $uuid = Dits::decodeDits($id);
        $user = Auth::user();
        $input = $request->all();

        if (!isset($request->uuid_madrasah)) {
            $operator = Operator::whereUuid($user->uuid_login)->first();
            $uuid_madrasah = $operator->uuid_madrasah;
        } else {
            $uuid_madrasah = Dits::decodeDits($request->uuid_madrasah);
            $operator = Operator::whereUuidMadrasah($uuid_madrasah)->first();
            if (is_null($operator)) {
                toast('Gagal, Madrasah Yang Di Pilih Belum Mempunyai Operator', 'error');
                return back();
            }
        }
        $madrasah = Madrasah::whereUuid($uuid_madrasah)
            ->first();

        $tgl_pembukaan = date('Y-m-d', strtotime($request->tgl_pembukaan));
        $tgl_penutupan = date('Y-m-d', strtotime($request->tgl_penutupan));
        $tgl_pengumuman = date('Y-m-d', strtotime($request->tgl_pengumuman));
        $thn = date('Y');

        $tahunpembukaan = date('Y', strtotime($tgl_pembukaan));
        $tahunpenutupan = date('Y', strtotime($tgl_penutupan));
        $tahunpengumuman = date('Y', strtotime($tgl_pengumuman));

        if ($tahunpembukaan != $thn || $tahunpenutupan != $thn || $tahunpengumuman != $thn) {
            toast('Gagal, Kesalahan Pemilihan Tahun!', 'error');
            return back();
        }

        if ($tgl_penutupan <= $tgl_pembukaan || $tgl_pengumuman <= $tgl_penutupan || $tgl_pengumuman <= $tgl_pembukaan) {
            toast('Gagal, Pengaturan Tanggal Pembukaan, Penutupan, dan Pengumunan Tidak Benar!', 'error');
            return back();
        }

        $valid = Validator::make($request->all(), [
            'url_brosur' => 'file|mimes:pdf|max:1000',
        ]);

        if ($valid->fails()) {
            toast('Gagal, File brosur tidak sesuai', 'error');
            return back();
        }

        $input = [
            'uuid_madrasah' => $uuid_madrasah,
            'uuid_operator' => $operator->uuid,
            'status_nomor' => $request->status_nomor,
            'tgl_pembukaan' => $tgl_pembukaan,
            'tgl_penutupan' => $tgl_penutupan,
            'tgl_pengumuman' => $tgl_pengumuman,
            'tahun_akademik' => $request->tahun_akademik,
        ];

        $pembukaan = Pembukaan::where('uuid', $uuid)->first();

        if ($request->hasFile('url_brosur')) {
            // Cek url_brosur
            if($pembukaan->url_brosur!=""){
                if(Storage::disk('public')->exists($pembukaan->url_brosur)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($pembukaan->url_brosur);
                }
            }
            // Upload File
            $ext = strtolower($request->file('url_brosur')->extension());
            $ext_array = Array('pdf');
            if (in_array($ext, $ext_array)){
                $file = $request->file('url_brosur');
                $pat_brosur = 'brosur/'.date('Y').'/';
                $file_name = Str::slug($pembukaan->madrasah->nama_madrasah,'-');
                $file_name = $file_name."-".rand(1000,9999999999).".".$ext;
                $file_save = $pat_brosur.$file_name;
                if(!is_dir(storage_path('app/public/'.$pat_brosur))){
                    Storage::disk('public')->makeDirectory($pat_brosur);
                }
                Storage::disk('public')->putFileAs($pat_brosur,$file,$file_name);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
            $input['url_brosur'] = $file_save;
        }

        $create = Pembukaan::where('uuid', $uuid)->first();
        $create->update($input);

        if ($create) {
            toast('Berhasil Memperbaharui PPDB', 'success');
            return redirect()->route('buka-ppdb');
        }
        toast('Gagal, Memperbaharui PPDB', 'error');
        return back();
    }

    public function detail($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::with('madrasah', 'operator')
            ->whereUuid($uuid)
            ->first();
        // return $data->madrasah;
        $pendaftaran = Pendaftaran::with('peserta')
            ->where('uuid_pembukaan', $uuid)->get();

        return view('pages.ppdb.detail', compact('data', 'pendaftaran'));
    }

    public function detailVerifikasi($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::with('madrasah', 'operator')
            ->whereUuid($uuid)
            ->first();
        // return $data->madrasah;
        $pendaftaran = Pendaftaran::with('peserta')
            ->where('uuid_pembukaan', $uuid)->get();

        return view('pages.ppdb.detail_verifikasi', compact('data', 'pendaftaran'));
    }

    public function delete($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::where('uuid', $uuid)
            ->first();

        $pendaftaran = Pendaftaran::where('uuid_pembukaan', $data->uuid)->get();

        if (count($pendaftaran) > 0) {
            toast('Gagal Menghapus PPDB', 'error');
            return back();
        }

        if ($data) {
            // Cek url_brosur
            if($data->url_brosur!=""){
                if(Storage::disk('public')->exists($data->url_brosur)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($data->url_brosur);
                }
            }
            $data->delete();
            toast('Berhasil Menghapus PPDB', 'success');
            return redirect()->route('buka-ppdb');
        }
        toast('Gagal Menghapus PPDB', 'error');
        return redirect()->route('buka-ppdb');
    }

    public function status($id)
    {
        $uuid = Dits::decodeDits($id);
        $pembukaan = Pembukaan::whereUuid($uuid)->first();
        if ($pembukaan->status_pembukaan == 'Dibuka') {
            $pembukaan->update([
                'status_pembukaan' => 'Ditutup',
            ]);
            toast('Berhasil Memperbaharui Status Menjadi "Ditutup"', 'success');
            return back();
        } else {
            $pembukaan->update([
                'status_pembukaan' => 'Dibuka',
            ]);
            toast('Berhasil Memperbaharui Status Menjadi "Dibuka"', 'success');
            return back();
        }
        toast('Gagal Memperbaharui Status', 'error');
        return back();
    }

    public function daftar($id, $u_madrasah)
    {
        $uuid = Dits::decodeDits($id);
        $peserta = Dits::DataPeserta();
        if ($peserta->status_aktif == 'no') {
            toast('Gagal Mendaftar, Silahkan isi data diri terlebih dahulu', 'error');
            return back();
        }

        $madrasah = Madrasah::whereUuid($u_madrasah)->first();

        $pembukaan = Pembukaan::where('uuid_madrasah', $madrasah->uuid)->first();
        if ($pembukaan->status_pembukaan == 'Ditutup') {
            toast('Gagal Mendaftar, PPDB pada madrasah ini telah di tutup', 'error');
            return back();
        }

        $uuid_peserta = Auth::user()->uuid_login;

        $cekUmur = Dits::hitungUmur($peserta->NIK, $peserta->jkl);

        // CEK KECOCOKAN TANGGAL LAHIR DENGAN NIK
        if($cekUmur!=$peserta->tgl){
            toast('Gagal Mendaftar, Tanggal Lahir Tidak Sesuai Dengan Tanggal Lahir di NIK/KK!', 'error');
            return back();
        }

        // $dateNow = date('Ymd'); Diubah Ke 1 Juli Tahun Berjalan Sesuai Juknis PPDB 2020
        // $cekUmur = $dateNow - str_replace('-', '', $cekUmur);
        // $umur = substr($cekUmur, 0, 2);
        $dateNow = date('Y') . "-07-01";
        $dateNow = date('Y-m-d', strtotime($dateNow));
        $date = new DateTime($cekUmur);
        $now = new DateTime($dateNow);
        $interval = $now->diff($date);
        $umur = $interval->y;
        $cekLayak = Dits::cekLayak($umur);

        if($umur=="5"){
            toast('Gagal Mendaftar, Umur Tidak Mencukupi Untuk Mendaftar Jenjang MI, Hubungi Pihak Madrasah.', 'error');
            return back();
        }

        if ($cekLayak != $madrasah->jenjang) {
            toast('Gagal Mendaftar, Silahkan pilih jenjang yang setara dengan umur anda', 'error');
            return back();
        }

        $check_pendaftaran = Pendaftaran::whereUuidPeserta($uuid_peserta)
            ->get('uuid_pembukaan');
        $check_pendaftaran_2 = Pendaftaran::whereUuidPeserta($uuid_peserta)
            ->where('uuid_pembukaan', $pembukaan->uuid)
            ->get();
        if ($check_pendaftaran->count() >= 3) {
            toast('Gagal, Anda Sudah Mendaftar ke 3 Madrasah', 'error');
            return back();
        } else if ($check_pendaftaran_2->count() >= 1) {
            toast('Gagal, Anda Sudah Mendaftar di madrasah ini', 'error');
            return back();
        }

        $nomor_pendaftaran = Dits::interval('pendaftarans', $pembukaan->uuid ,'nomor_pendaftaran');
        $input = array(
            'uuid' => Str::uuid(),
            'uuid_pembukaan' => $uuid,
            'uuid_peserta' => $uuid_peserta,
            'kode_pendaftaran' => Dits::generateCode(),
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'status_pendaftaran' => 'Baru',
            'status_diterima' => 'Tahap Seleksi',
            'jalur_diterima' => '',
            'url_transfer' => '',
            'status_transfer' => '',
            'tgl_pendaftaran' => Carbon::now(),
        );

        $pendaftaran = Pendaftaran::create($input);

        if ($pendaftaran) {
            toast('Berhasil Mendaftarkan Ke Madrasah yang Di Tuju', 'success');
            return back();
        }
        toast('Gagal Mendaftarkan Ke Madrasah yang Di Tuju', 'error');
        return back();
    }

    public function madrasahTerpilih()
    {
        return view('pages.ppdb.madrasah-terpilih');
    }

    public function madrasahTerpilihData()
    {
        $uuid = Auth::user()->uuid_login;
        $data = Pendaftaran::join('pembukaans', 'pembukaans.uuid', '=', 'pendaftarans.uuid_pembukaan')
            ->join('madrasahs', 'madrasahs.uuid', '=', 'pembukaans.uuid_madrasah')
            ->whereUuidPeserta($uuid)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . Dits::PdfViewer($item->url_brosur) . '" target="_blank" class="btn btn-danger btn-sm btn-block"><i class="fas fa-file-pdf"></i> Brosur</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'ppdb/' . Dits::encodeDits($item->uuid_madrasah) . '/' . $item->kode_pendaftaran . '/lihat" class="btn btn-info btn-sm btn-block" ><i class="fas fa-eye"></i> Lihat</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'ppdb/' . Dits::encodeDits($item->uuid_pembukaan) . '/hapus" onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> Hapus</a>';
                $btn .= '<a href="' . route('print.data', [Dits::DataPeserta()->NIK, Dits::encodeDits($item->kode_pendaftaran)]) . '" class="btn btn-success btn-sm btn-block" target="_blank"><i class="fas fa-print"></i> Cetak</a>';
                if ($item->status_diterima == 'Diterima') {
                    $btn .= '<a href="' . \env('APP_URL') . 'ppdb/sub/daftar-ulang/' . Dits::encodeDits($item->kode_pendaftaran) . '/" class="btn btn-dark btn-sm btn-block"><i class="fas fa-coins"></i> Daftar Ulang</a>';
                }
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);

    }

    public function hapus($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $uuid_peserta = Auth::user()->uuid_login;

        $pendaftaran = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->whereUuidPeserta($uuid_peserta)
            ->first();
        if ($pendaftaran->status_pendaftaran != 'Baru') {
            toast('Gagal Menghapus, Status Pendaftaran Anda bukan "Baru"', 'error');
            return back();
        }

        if ($pendaftaran) {
            $pendaftaran->delete();
            toast('Berhasil Menghapus', 'success');
            return back();
        }
        toast('Gagal Menghapus', 'error');
        return back();
    }

    public function pengumuman($id, $kode = '')
    {
        $uuid = Dits::decodeDits($id);
        // return $uuid;
        $data = Pendaftaran::where('kode_pendaftaran', $kode)
            ->first();
        return view('pages.ppdb.pengumuman.create_edit', compact('id', 'data'));
    }

    public function storePengumuman(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        $pendaftaran = Pendaftaran::where('kode_pendaftaran', $request->kode_pendaftaran)
            ->first();
        if ($pendaftaran) {
            $pendaftaran->update([
                'status_diterima' => $request->status_diterima,
                'jalur_diterima' => $request->jalur_diterima,
            ]);
            toast('Berhasil Membuat Pengumuman', 'success');
            return back();
        }
        toast('Gagal Membuat Pengumuman', 'error');
        return back();
    }

    public function updatePengumuman(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        // return $uuid;
        $pendaftaran = Pendaftaran::where('kode_pendaftaran', $request->kode_pendaftaran)
            ->whereStatusPendaftaran('Lolos Tahap Dokumen')
            ->first();
        // return $pendaftaran;
        if ($pendaftaran) {
            $pendaftaran->update([
                'status_diterima' => $request->status_diterima,
                'jalur_diterima' => $request->jalur_diterima,
            ]);
            toast('Berhasil Membuat Pengumuman', 'success');
            return back();
        }
        toast('Gagal Membuat Pengumuman, Peserta Tidak Ada/Tidak Lolos Tahap Dokumen.', 'error');
        return back();
    }

    public function data()
    {
        $uuid_operator = Auth::user()->uuid_login;
        if (Auth::user()->role == 'Operator Madrasah') {
            $data = Pembukaan::with('madrasah', 'operator')
                ->where('uuid_operator', $uuid_operator)
                ->get();
        } else {
            $data = Pembukaan::with('madrasah', 'operator')
                ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '" class="btn btn-dark btn-sm btn-block"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail-verifikasi/' . Dits::encodeDits($item->uuid) . '" class="btn btn-info btn-sm btn-block"><i class="fa fa-bullhorn"></i> Verifikasi Peserta</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function dataByID($id)
    {
        $jenjang = Dits::decodeDits($id);
        $data = Madrasah::join('pembukaans', 'pembukaans.uuid_madrasah', '=', 'madrasahs.uuid')
            ->whereJenjang($jenjang)
            ->where('status_pembukaan', 'Dibuka')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tgl_pembukaan', function ($item) {
                $tgl_pembukaan = date('d-m-Y', strtotime($item->tgl_pembukaan));
                return $tgl_pembukaan;
            })
            ->addColumn('tgl_penutupan', function ($item) {
                $tgl_penutupan = date('d-m-Y', strtotime($item->tgl_penutupan));
                return $tgl_penutupan;
            })
            ->addColumn('tgl_pengumuman', function ($item) {
                $tgl_pengumuman = date('d-m-Y', strtotime($item->tgl_pengumuman));
                return $tgl_pengumuman;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . Dits::PdfViewer($item->url_brosur) . '" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Brosur</a> ';
                $btn .= '<a href="' . \env('APP_URL') . 'ppdb/' . Dits::encodeDits($item->uuid_madrasah) . '/lihat" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> ';
                $btn .= '<a href="' . \env('APP_URL') . 'ppdb/' . Dits::encodeDits($item->uuid) . '/daftar/' . $item->uuid_madrasah . '" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Daftar</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show($id, $kode = null)
    {
        $uuid = Dits::decodeDits($id);
        $uuid_peserta = Auth::user()->uuid_login;
        $data = Madrasah::with('pembukaan')
            ->whereUuid($uuid)
            ->first();
        $pendaftaran = Pendaftaran::with('pembukaan')
            ->where('kode_pendaftaran', $kode)
            ->first();
        // return $pendaftaran;
        return view('pages.ppdb.madrasah.detail', compact('data', 'pendaftaran'));
    }

    public function daftarUlang($kode)
    {
        $kode_pendaftaran = Dits::decodeDits($kode);
        $data = Pendaftaran::where('kode_pendaftaran', $kode_pendaftaran)
            ->first();
        return view('pages.ppdb.daftar-ulang', compact('kode', 'data'));
    }

    public function daftarUlangStore(Request $request, $kode)
    {
        $kode_pendaftaran = Dits::decodeDits($kode);

        $nik = Dits::DataPeserta()->NIK;
        $pendaftaran = Pendaftaran::where('kode_pendaftaran', $kode_pendaftaran)
            ->first();

        if ($request->hasFile('url_transfer')) {

            $request->validate([
                "url_transfer" => "required|file|mimes:png,jpg,jpeg|max:1000"
            ]);

            // Cek url_transfer
            if($pendaftaran->url_transfer!=""){
                if(Storage::disk('public')->exists($pendaftaran->url_transfer)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($pendaftaran->url_transfer);
                }
            }
            // Upload File
            $ext = strtolower($request->file('url_transfer')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('url_transfer');
                $path_PasFoto = 'peserta/'.date('Y').'/'.$pendaftaran->peserta->NIK.'/daftar-ulang/';
                $file_name = Str::slug(strtoupper($pendaftaran->peserta->nama),'-');
                $file_name = $file_name."-".rand(1000,9999999999).".jpg";
                $file_save = $path_PasFoto.$file_name;
                if(!is_dir(storage_path('app/public/'.$path_PasFoto))){
                    Storage::disk('public')->makeDirectory($path_PasFoto);
                }
                Storage::disk('public')->putFileAs($path_PasFoto,$file,$file_name);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }

            if ($pendaftaran) {
                $pendaftaran->update([
                    'url_transfer' => $file_save,
                ]);
                toast('Berhasil Upload', 'success');
                return back();
            }
            toast('Gagal Upload', 'error');
            return back();
        }

    }

    public function daftarUlangDelete($kode)
    {
        $kode_pendaftaran = Dits::decodeDits($kode);
        $data = Pendaftaran::where('kode_pendaftaran', $kode_pendaftaran)
            ->first();
        if ($data) {
            // Cek url_transfer
            if($data->url_transfer!=""){
                if(Storage::disk('public')->exists($data->url_transfer)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($data->url_transfer);
                }
            }
            $data->update([
                'url_transfer' => '',
            ]);
            toast('Berhasil Hapus File', 'success');
            return back();
        }
        toast('Gagal Hapus File', 'error');
        return back();
    }

    public function uploadDocument(Request $request, $field)
    {
        $nik = Dits::DataPeserta()->NIK;
        $uuid_peserta = Auth::user()->uuid_login;
        $peserta = Peserta::whereUuid($uuid_peserta)->first();

        $valid = Validator::make($request->all(), [
            $field => 'file|mimes:pdf,jpeg,jpg,png|max:1000',
        ]);

        if ($valid->fails()) {
            toast('Gagal, File brosur tidak sesuai/file terlalu besar!', 'error');
            return back();
        }

        if ($request->hasFile($field)) {
            if($peserta->$field!=""){
                if(Storage::disk('public')->exists($peserta->$field)){
                    // Hapus $field
                    Storage::disk('public')->delete($peserta->$field);
                }
            }
            // Upload Pas Foto
            $ext = strtolower($request->file($field)->extension());
            $ext_array = Array('pdf','jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file($field);
                $change_field = Str::slug($field,'-');
                $path_file = 'peserta/'.date('Y').'/'.$peserta->NIK.'/'.$change_field.'/';
                $file_name = Str::slug($peserta->nama,'-');
                $file_name = $change_field."-".$file_name."-".rand(1000,9999999999).".".$ext;
                $file_save = $path_file.$file_name;
                if(!is_dir(storage_path('app/public/'.$path_file))){
                    Storage::disk('public')->makeDirectory($path_file);
                }
                Storage::disk('public')->putFileAs($path_file,$file,$file_name);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }

            $peserta->update([
                $field => $file_save,
            ]);
            if ($peserta) {
                toast('Berhasil Upload File', 'success');
                return back();
            }
            toast('Gagal Upload File', 'error');
            return back();
        }
        toast('Gagal, Tipe file tidak valid!', 'error');
        return back();
    }

    public function deleteDocument($field, $nik)
    {
        $data = Peserta::where('NIK', $nik)->first();
        if ($data) {
            if($data->$field!=""){
                if(Storage::disk('public')->exists($data->$field)){
                    // Hapus $field
                    Storage::disk('public')->delete($data->$field);
                }
            }
            $data->update([
                $field => '',
            ]);
            if ($data) {
                toast('Berhasil Hapus File', 'success');
                return back();
            }
            toast('Gagal Hapus File', 'error');
            return back();
        }
        toast('Data tidak ada', 'error');
        return back();
    }

}

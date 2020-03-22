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
use Dits;
use Illuminate\Http\Request;
use Str;
use Validator;

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
            'uuid_madrasah' => 'required|string|max:100',
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
            'url_brosur' => 'file|mimes:pdf|max:300',
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
            $fileName = Carbon::now()->timestamp . '.' .
            $request->file('url_brosur')->getClientOriginalExtension();
            $uploadPdf = $request->file('url_brosur')->move(
                base_path() . '/public/document/brosur', $fileName
            );
            $input['url_brosur'] = $uploadPdf;
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
            'url_brosur' => 'file|mimes:pdf|max:300',
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

        if ($request->hasFile('url_brosur')) {
            $fileName = Carbon::now()->timestamp . '.' .
            $request->file('url_brosur')->getClientOriginalExtension();
            $uploadPdf = $request->file('url_brosur')->move(
                base_path() . '/public/document/brosur', $fileName
            );
            $input['url_brosur'] = $uploadPdf;
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
        $dateNow = date('Ymd');
        $cekUmur = $dateNow - str_replace('-', '', $cekUmur);
        $umur = substr($cekUmur, 0, 2);

        $cekLayak = Dits::cekLayak($umur);

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
            toast('Gagal, Kamu Sudah Mendaftar ke 3 Sekolah', 'error');
            return back();
        } else if ($check_pendaftaran_2->count() >= 1) {
            toast('Gagal, Kamu Sudah Mendaftar di madrasah ini', 'error');
            return back();
        }

        $nomor_pendaftaran = Dits::interval('pendaftarans', 'nomor_pendaftaran');
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
            toast('Berhasil Mendaftarkan Ke Sekolah yang Di Tuju', 'success');
            return back();
        }
        toast('Gagal Mendaftarkan Ke Sekolah yang Di Tuju', 'error');
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
                $btn = '<a href="' . Dits::PdfViewer(asset($item->url_brosur)) . '" target="_blank" class="btn btn-danger btn-sm btn-block"><i class="fas fa-file-pdf"></i> Brosur</a>';
                $btn .= '<a href="/ppdb/' . Dits::encodeDits($item->uuid_madrasah) . '/' . $item->kode_pendaftaran . '/lihat" class="btn btn-info btn-sm btn-block" ><i class="fas fa-eye"></i> Lihat</a>';
                $btn .= '<a href="/ppdb/' . Dits::encodeDits($item->uuid_pembukaan) . '/hapus" onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> Hapus</a>';
                $btn .= '<a href="' . route('print.data', [Dits::DataPeserta()->NIK, Dits::encodeDits($item->kode_pendaftaran)]) . '" class="btn btn-success btn-sm btn-block" target="_blank"><i class="fas fa-print"></i> Cetak</a>';
                if ($item->status_diterima == 'Diterima') {
                    $btn .= '<a href="/ppdb/sub/daftar-ulang/' . Dits::encodeDits($item->kode_pendaftaran) . '/" class="btn btn-dark btn-sm btn-block"><i class="fas fa-coins"></i> Daftar Ulang</a>';
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
        if ($pendaftaran->status_pendaftaran != 'Baru' || $pendaftaran->status_pendaftaran != 'baru') {
            toast('Gagal Menghapus, Status Pendaftaran kamu bukan "Baru"', 'error');
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
        toast('Gagal Membuat Pengumuman', 'error');
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
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . Dits::PdfViewer(asset($item->url_brosur)) . '" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Brosur</a> ';
                $btn .= '<a href="/ppdb/' . Dits::encodeDits($item->uuid_madrasah) . '/lihat" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> ';
                $btn .= '<a href="/ppdb/' . Dits::encodeDits($item->uuid) . '/daftar/' . $item->uuid_madrasah . '" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Daftar</a>';
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

        if ($request->hasFile('url_transfer')) {

            $fileName = Carbon::now()->timestamp . '.' .
            $request->file('url_transfer')->getClientOriginalExtension();
            $upload = $request->file('url_transfer')->move(
                base_path() . '/public/document/peserta/' . $nik . '/bukti_transfer/', $fileName
            );

            $pendaftaran = Pendaftaran::where('kode_pendaftaran', $kode_pendaftaran)
                ->first();
            if ($pendaftaran) {
                $pendaftaran->update([
                    'url_transfer' => $upload,
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
        // return $data->url_transfer;
        if ($data) {
            unlink($data->url_transfer);
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
            $field => 'file|mimes:pdf,jpeg,jpg,png|max:300',
        ]);

        if ($valid->fails()) {
            toast('Gagal, File brosur tidak sesuai', 'error');
            return back();
        }

        if ($request->hasFile($field)) {
            $fileName = Carbon::now()->timestamp . '.' .
            $request->file($field)->getClientOriginalExtension();
            $uploadPdf = $request->file($field)->move(
                base_path() . '/public/document/peserta/' . $nik . '/' . $field . '/', $fileName
            );
            $peserta->update([
                $field => $uploadPdf,
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
            unlink($data->$field);
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

<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Jawaban;
use App\Models\Madrasah;
use App\Models\Operator;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Soal;
use App\User;
use Auth;
use Carbon\Carbon;
use Cookie;
use DataTables;
use Dits;
use Illuminate\Http\Request;
use Str;
use Validator;

class CATController extends Controller
{
    public function index()
    {
        $uuid_peserta = \Auth::user()->uuid_login;
        $data = \App\Models\Peserta::where('uuid', $uuid_peserta)->first();
        return view('pages.CAT.index', compact('data'));
    }

    public function testUjian($kode_soal)
    {
        $kode_soal = Dits::decodeDits($kode_soal);
        $bank_soal = BankSoal::where('kode_soal' , $kode_soal)->first();
        $uuid_peserta = Auth::user()->uuid_login;

        $soal      = Soal::where('kode_soal' , $kode_soal)
                            ->orderBy('nomor_soal' , 'ASC')
                            ->get();

        $madrasah    = Madrasah::where('uuid' , $bank_soal->uuid_madrasah)->first();
        $pembukaan   = Pembukaan::where('uuid_madrasah' , $madrasah->uuid)
                                    ->where('status_pembukaan' , 'Dibuka')
                                    ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                    ->where('uuid_pembukaan' , $pembukaan->uuid)
                                    ->first();
        return view('pages.CAT.ujian.ikut_ujian' , compact('soal' , 'pendaftaran' , 'bank_soal'));
    }

    public function saveUjian(Request $request)
    {
        
        $uuid_jawaban = Dits::decodeDits($request->uuid_jawaban);
        $nomor_soal   = Dits::decodeDits($request->nomor_soal);
        $kode_soal    = Dits::decodeDits($request->kode_soal);
        $kode_pendaftaran = Dits::decodeDits($request->kode_pendaftaran);
        $nums         = Dits::decodeDits($request->nums);

        if($request->jawaban) {
            $jawaban = implode('"' ,$request->jawaban);
        } else {
            $jawaban = '';
        }

        $jawab = Soal::where('kode_soal' , $kode_soal)
                            ->where('nomor_soal' , $nomor_soal)
                            ->first();
        if($jawaban == $jawab->kunci_jawaban) {
            $status_jawaban = 'Benar';
        } elseif ($jawaban == '') {
            $status_jawaban = '';
        } else {
            $status_jawaban = 'Salah';
        }

        $checkJawaban = Jawaban::where('kode_soal' , $kode_soal)
                                    ->where('kode_pendaftaran' , $kode_pendaftaran)
                                    ->where('nomor_soal' , $nomor_soal)
                                    ->first();
        if($checkJawaban) {
            $checkJawaban->update([
                'kode_soal'         => $kode_soal,
                'kode_pendaftaran'  => $kode_pendaftaran,
                'nomor_soal'        => $nomor_soal,
                'jawaban'           => strtoupper($jawaban),
                'status_jawaban'    => $status_jawaban,
                'tgl_cat'           => Carbon::now()
            ]);
        } else {
            $store   = Jawaban::create([
                                    'uuid'              => Str::uuid(),
                                    'kode_soal'         => $kode_soal,
                                    'kode_pendaftaran'  => $kode_pendaftaran,
                                    'nomor_soal'        => $nomor_soal,
                                    'jawaban'           => strtoupper($jawaban),
                                    'status_jawaban'    => $status_jawaban,
                                    'tgl_cat'           => Carbon::now()
                                ]);
        }

        
        if ($checkJawaban OR $store) {
            return response()->json([
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
            ], 500);
        }

    }

    public function store(Request $request)
    {

        $bank_soal = BankSoal::where('kode_soal', $request->kode_soal)->first();
        $uuid_peserta = Auth::user()->uuid_login;

        if (!$bank_soal) {
            toast('Gagal memasuki halaman ujian, Kode tidak valid', 'error');
            return redirect()->route('cat.index');
        }

        $soal = Soal::where('kode_soal', $request->kode_soal)->get();

        $madrasah = Madrasah::where('uuid', $bank_soal->uuid_madrasah)->first();
        $pembukaan = Pembukaan::where('uuid_madrasah', $madrasah->uuid)
            ->where('status_pembukaan', 'Dibuka')
            ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta', $uuid_peserta)
            ->where('uuid_pembukaan', $pembukaan->uuid)
            ->first();

        $jawaban = Jawaban::where('kode_soal', $request->kode_soal)
            ->where('kode_pendaftaran', $pendaftaran->kode_pendaftaran)
            ->get();

        if ($pendaftaran->status_pendaftaran != 'Lolos Tahap Dokumen') {
            toast('Gagal memasuki halaman ujian, Status Pendaftaran kamu ' . $pendaftaran->status_pendaftaran, 'error');
            return redirect()->route('cat.index');
        }

        if ($bank_soal->status_bank_soal == 'Tidak Aktif') {
            toast('Gagal memasuki halaman ujian, Status soal tidak aktif', 'error');
            return redirect()->route('cat.index');
        }

        if ($bank_soal->crash_session == 'No') {

            if ($jawaban->count() >= $soal->count()) {
                toast('Gagal memasuki halaman ujian, Kamu sudah mengikuti ujian ini','error');
                return redirect()->route('cat.index');
            }
        }

        $minutes = $bank_soal->timer_cat;

        return redirect()->route('cat.ujian' , Dits::encodeDits($request->kode_soal));
    }

    public function start($no = 1)
    {

        if (strlen($no) > 4) {
            $no = Dits::decodeDits($no);
        }

        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);

        if (!$get_cookie) {
            toast('Gagal memasuki halaman ujian, Sesi sudah habis', 'error');
            return redirect()->route('cat.index');
        }
        $cookie_value = json_decode($get_cookie, true);

        $count_soal = Soal::where('kode_soal', $cookie_value)->count();

        $nama_cookie = Dits::encodeDits('DitsWaktu');
        $dapat_cookie = Cookie::get($nama_cookie);
        $waktu_mulai = json_decode($dapat_cookie);

        // $count_soal = str_replace('' , '"' , $count_soal);
        $no = intval($no);

        if ($no === $count_soal) {
            $finish = true;
        } else {
            $finish = false;
        }

        $soal = Soal::where('kode_soal', $cookie_value)
            ->where('nomor_soal', $no)
            ->first();
        if (!$soal) {
            toast('Gagal memasuki halaman ujian, Soal tidak di temukan', 'error');
            return redirect()->route('cat.index');
        }
        $navigasi = Soal::where('kode_soal', $cookie_value)
            ->orderBy('nomor_soal', 'ASC')
            ->get();

        $bank_soal = BankSoal::where('kode_soal', $cookie_value)->first();
        $uuid_peserta = Auth::user()->uuid_login;
        $madrasah    = Madrasah::where('uuid' , $bank_soal->uuid_madrasah)->first();
        $pembukaan   = Pembukaan::where('uuid_madrasah' , $madrasah->uuid)
                                    ->where('status_pembukaan' , 'Dibuka')
                                    ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                    ->where('uuid_pembukaan' , $pembukaan->uuid)
                                    ->first();
        

        $jawaban  = Jawaban::where('kode_soal' , $cookie_value)
                                ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                                ->where('nomor_soal' , $no)
                                ->orderBy('nomor_soal' , 'ASC')
                                ->get();
        
        $jawaban_peserta  = Jawaban::where('kode_soal' , $cookie_value)
                                ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                                ->where('nomor_soal' , $no)
                                ->first();

                                // return $jawaban_peserta;
                            
        return view('pages.CAT.soal' , compact('no' , 'soal' , 'navigasi' , 'finish' , 'jawaban' , 'bank_soal' , 'waktu_mulai', 'jawaban_peserta'));
    }

    public function storeJawaban(Request $request, $no)
    {
        $hashName = Dits::encodeDits('kode_soal');
        $kode_soal = Dits::decodeDits($request->$hashName);
        $no = Dits::decodeDits($no);

        $uuid_peserta = Auth::user()->uuid_login;

        $soal = BankSoal::where('kode_soal', $kode_soal)->first();
        $madrasah = Madrasah::where('uuid', $soal->uuid_madrasah)->first();
        $pembukaan = Pembukaan::where('uuid_madrasah', $madrasah->uuid)
            ->where('status_pembukaan', 'Dibuka')
            ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta', $uuid_peserta)
            ->where('uuid_pembukaan', $pembukaan->uuid)
            ->first();

        if ($request->jawaban) {
            $jawaban = implode('"', $request->jawaban);
        } else {
            $jawaban = null;
        }

        $jawab = Soal::where('kode_soal', $kode_soal)
            ->where('nomor_soal', $no)
            ->first();
        if ($jawaban == $jawab->kunci_jawaban) {
            $status_jawaban = 'Benar';
        } else {
            $status_jawaban = 'Salah';
        }

        $checkJawaban = Jawaban::where('kode_soal', $kode_soal)
            ->where('kode_pendaftaran', $pendaftaran->kode_pendaftaran)
            ->where('nomor_soal', $no)
            ->first();
        if ($checkJawaban) {
            $checkJawaban->update([
                'kode_soal' => $kode_soal,
                'kode_pendaftaran' => $pendaftaran->kode_pendaftaran,
                'nomor_soal' => $no,
                'jawaban' => $jawaban,
                'status_jawaban' => $status_jawaban,
                'tgl_cat' => Carbon::now(),
            ]);
        } else {
            $store = Jawaban::create([
                'uuid' => Str::uuid(),
                'kode_soal' => $kode_soal,
                'kode_pendaftaran' => $pendaftaran->kode_pendaftaran,
                'nomor_soal' => $no,
                'jawaban' => $jawaban,
                'status_jawaban' => $status_jawaban,
                'tgl_cat' => Carbon::now(),
            ]);
        }

        $next = $no + 1;
        if (isset($request->finish)) {
            toast('Ujian telah selesai', 'success');
            return redirect()->route('cat.index');
        }
        return redirect()->route('cat.start', Dits::encodeDits($next));
    }

    public function end()
    {
        $minutes = 0.001;
        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);
        $cookie_value = json_decode($get_cookie, true);

        if ($cookie_value) {
            $unset_cookie = Cookie::queue(Cookie::make($cookie_name, $cookie_value, $minutes));
            if ($unset_cookie) {
                return redirect()->route('cat.index');
            }
            return redirect()->route('cat.end');
        }
        toast('Berhasil keluar dari halaman ujian', 'success');
        return redirect()->route('cat.index');

    }

    /**
     * ===============================
     * ******** Operator Side ********
     * ===============================
     */

    public function bankSoal()
    {
        return view('pages.CAT.operator.index');
    }

    public function create()
    {
        $uuid_operator = Auth::user()->uuid_login;
        $data = Operator::with('madrasah')
            ->where('uuid', $uuid_operator)
            ->first();
        $madrasah = Madrasah::orderBy('nama_madrasah', 'ASC')->get();
        return view('pages.CAT.operator.create_edit', compact('data', 'madrasah'));
    }

    public function storeBank(Request $request)
    {
        // Validation
        $request->validate([
            'nama_madrasah' => 'required|string|max:100'
        ]);

        $uuid_operator = Auth::user()->uuid_login;

        if (Auth::user()->role != 'Operator Kemenag') {
            $madrasah = Madrasah::where('nama_madrasah', $request->nama_madrasah)->first();
            $uuid_madrasah = $madrasah->uuid;
        } else {
            $operator = Operator::with('madrasah')
                ->where('uuid', $uuid_operator)
                ->first();
            $uuid_madrasah = $operator->madrasah['uuid'];
        }

        $kode_soal = Dits::genKodeSoal('4');
        $bank_soal = BankSoal::create([
            'uuid' => Str::uuid(),
            'uuid_madrasah' => $uuid_madrasah,
            'uuid_operator' => $uuid_operator,
            'kode_soal' => $kode_soal,
            'status_bank_soal' => 'Aktif',
            'crash_session' => 'No',
            'timer_cat' => 90,
            'tgl_bank_soal' => Carbon::now(),
        ]);
        if ($bank_soal) {
            toast('Berhasil Menambah Bank Soal', 'success');
            return redirect()->route('bank-soal.index');
        }
    }

    public function crashBank($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = BankSoal::where('uuid', $uuid)->first();

        if ($data) {

            if ($data->crash_session == 'No') {
                $crash_session = 'Yes';
            } else if ($data->crash_session == 'Yes') {
                $crash_session = 'No';
            }

            $data->update([
                'crash_session' => $crash_session,
            ]);

            toast('Berhasil Memperbaharui Status Crash', 'success');
            return redirect()->route('bank-soal.detail', $id);
        }
    }

    public function statusBank($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = BankSoal::where('uuid', $uuid)->first();

        if ($data) {

            if ($data->status_bank_soal == 'Tidak Aktif') {
                $status_bank_soal = 'Aktif';
            } else if ($data->status_bank_soal == 'Aktif') {
                $status_bank_soal = 'Tidak Aktif';
            }

            $data->update([
                'status_bank_soal' => $status_bank_soal,
            ]);

            toast('Berhasil Memperbaharui Status Bank', 'success');
            return redirect()->route('bank-soal.detail', $id);
        }
    }

    public function hapusBank($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = BankSoal::where('uuid', $uuid)->first();

        if ($data) {
            $data->delete();
            toast('Berhasil Menghapus Bank Soal', 'success');
            return redirect()->route('bank-soal.index');
        }
        toast('Gagal Menghapus Bank Soal', 'error');
        return redirect()->route('bank-soal.index');
    }

    public function detail($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = BankSoal::with('madrasah')
            ->whereUuid($uuid)
            ->first();
        return view('pages.CAT.operator.detail', compact('data'));
    }

    public function tulisSoal($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = BankSoal::where('uuid', $uuid)->first();
        $edit = false;
        return view('pages.CAT.operator.tulis-soal', compact('data', 'edit'));
    }

    public function storeSoal(Request $request, $id)
    {
        // Validation
        $request->validate([
            'jenis_soal' => 'required|string',
            'nomor_soal' => 'required|string',
            'a' => 'required|string',
            'b' => 'required|string',
            'c' => 'required|string',
            'd' => 'required|string',
            'kunci_jawaban' => 'required|string',
        ]);

        $uuid_operator = Auth::user()->uuid_login;
        $kode_soal = $id;

        $valid = Validator::make($request->all(), [
            'gambar' => 'image|mimes:jpeg,jpg,png|max:300',
        ]);

        if ($valid->fails()) {
            toast('Gagal menambah soal, Gambar tidak sesuai', 'error');
            return back();
        }

        if ($request->hasFile('gambar')) {
            $gambar = Dits::uploadImage($request, 'gambar', 'Soal/' . $kode_soal);
        } else {
            $gambar = null;
        }

        $soal = Soal::create([
            'uuid' => Str::uuid(),
            'uuid_operator' => $uuid_operator,
            'kode_soal' => $kode_soal,
            'jenis_soal' => $request->jenis_soal,
            'nomor_soal' => $request->nomor_soal,
            'soal' => $request->soal,
            'gambar' => $gambar,
            'a' => $request->a,
            'b' => $request->b,
            'c' => $request->c,
            'd' => $request->d,
            'kunci_jawaban' => $request->kunci_jawaban,
            'tgl_soal' => Carbon::now(),
        ]);
        if ($soal) {
            toast('Berhasil Menambah Soal', 'success');
            return back();
        }
    }

    public function updateTimer(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        $bank_soal = BankSoal::where('uuid', $uuid)
            ->first();
        if ($bank_soal) {
            $bank_soal->update([
                'timer_cat' => $request->timer_cat,
            ]);
            if ($bank_soal) {
                toast('Berhasil Memperbaharui Waktu CAT', 'success');
                return back();
            }
        }
    }

    public function data()
    {
        $data = BankSoal::with('madrasah')->get();

         return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                return '<a href="' . \env('APP_URL') . '/CAT/Bank/Soal/detail/'.Dits::encodeDits($item->uuid).'" class="btn btn-dark btn-sm"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                            })
                            ->escapeColumns([])
                            ->make(true);
     }

     public function detailData($id)
     {
        $id = Dits::decodeDits($id);
        $data = Jawaban::where('kode_soal' , $id)
                            ->groupBy('kode_pendaftaran')
                            ->get();
                        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_peserta', function ($item) {
                $pendaftaran = Pendaftaran::where('kode_pendaftaran', $item->kode_pendaftaran)->first();
                $peserta = Peserta::where('uuid', $pendaftaran->uuid_peserta)->first();
                return $pendaftaran->peserta->nama;
            })
            ->addColumn('jawaban_benar', function ($item) {
                $jawaban_benar = Jawaban::where('status_jawaban', 'Benar')
                    ->where('kode_soal', $item->kode_soal)
                    ->where('kode_pendaftaran', $item->kode_pendaftaran)
                    ->count();
                return $jawaban_benar;
            })
            ->addColumn('jawaban_salah', function ($item) {
                $jawaban_benar = Jawaban::where('status_jawaban', 'Salah')
                    ->where('kode_soal', $item->kode_soal)
                    ->where('kode_pendaftaran', $item->kode_pendaftaran)
                    ->count();
                return $jawaban_benar;
            })
            ->addColumn('tidak_jawab', function ($item) {
                $jawaban_benar = Jawaban::where('jawaban', '')
                    ->where('kode_soal', $item->kode_soal)
                    ->where('kode_pendaftaran', $item->kode_pendaftaran)
                    ->count();
                return $jawaban_benar;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('export.peserta-ujian.detail', [$item->kode_pendaftaran, $item->kode_soal]) . '" class="btn btn-success btn-block btn-sm"><i class="fas fa-file-excel"></i> Export Jawaban</a>';
                $btn .= '<a href="" class="btn btn-danger btn-block btn-sm"><i class="fas fa-trash"></i> Hapus Peserta</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function soalData($id)
    {
        $id = Dits::decodeDits($id);
        $data = Soal::where('kode_soal', $id)
            ->orderBy('created_at','ASC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('bank-soal.edit-soal', Dits::encodeDits($item->uuid)) . '" class="btn btn-info btn-sm m-1"><i class="fa fa-edit"></i></a>';
                $btn .= '<a href="' . route('bank-soal.lihat.soal', Dits::encodeDits($item->uuid)) . '" target="_blank" class="btn btn-warning btn-sm m-1"><i class="fa fa-eye"></i></a>';
                $btn .= '<a href="' . route('bank-soal.hapus.soal', Dits::encodeDits($item->uuid)) . '" onclick="return confirm_delete()" class="btn btn-danger btn-sm m-1"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function editSoal($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Soal::whereUuid($uuid)
            ->first();
        $edit = true;
        return view('pages.CAT.operator.tulis-soal', compact('data', 'edit'));
    }

    public function updateSoal(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        $input = $request->all();
        $soal = Soal::whereUuid($uuid)
            ->first();
        $kode_soal = $soal->kode_soal;

        $valid = Validator::make($request->all(), [
            'gambar' => 'image|mimes:jpeg,jpg,png|max:300',
        ]);
 
        if ($valid->fails()) {
            toast('Gagal menambah soal, Gambar tidak sesuai', 'error');
            return back();
        }

        if ($request->hasFile('gambar')) {
            $gambar = Dits::uploadImage($request, 'gambar', 'Soal/' . $kode_soal);
            $input['gambar'] = $gambar;
        }

        if ($soal) {
            $soal->update($input);
            if ($soal) {
                toast('Berhasil Memperbaharui Soal', 'success');
                return back();
            }
            toast('Gagal Memperbaharui Soal', 'error');
            return back();
        }
        toast('Gagal Memperbaharui Soal, Soal tidak ditemukan', 'error');
        return back();
    }

    public function hapusSoal($id)
    {
        $uuid = Dits::decodeDits($id);
        $soal = Soal::whereUuid($uuid)->first();
        if ($soal) {
            $soal->delete();
            if ($soal) {
                toast('Berhasil Menghapus Soal', 'success');
                return back();
            }
            toast('Gagal Menghapus Soal', 'error');
            return back();
        }
        toast('Gagal Menghapus Soal, Soal tidak ditemukan', 'error');
        return back();
    }

    public function lihatSoal($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Soal::whereUuid($uuid)->first();
        return view('pages.CAT.operator.preview-soal', compact('data'));
    }
}

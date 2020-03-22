<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\BankSoal;
use App\Models\Jawaban;
use App\Models\Soal;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;
use DataTables;
use Alert;
use Hash;
use Cookie;

class CATController extends Controller
{
    public function index()
    {
        return Dits::sendResponse('Success Access API');
    }

    public function create(Request $request) 
    {
        $bank_soal      = BankSoal::where('kode_soal' , $request->kode_soal)->first();
        $uuid_peserta   = $request->uuid_login;
        $soal           = Soal::where('kode_soal' , $request->kode_soal)->get();
        $bank_soal      = ankSoal::where('kode_soal' , $kode_soal)->first();

        $data = [
            // 'cookie_ujian' => [
            //     'cookie_name'   => base64_encode('DitsUjian'),
            //     'cookie_value'  => json_encode($request->kode_soal),
            //     'minute'        => $bank_soal->timer_cat
            // ],
            // 'cookie_waktu_ujian' => [
            //     'cookie_name'   => base64_encode('DitsWaktu'),
            //     'cookie_value'  => json_encode(Carbon::now()),
            //     'minute'        => $bank_soal->timer_cat
            // ],
            // 'nomer_soal'        => 1
            'kode_soal'     => Dits::encodeDits($request->kode_soal),
            'uuid_peserta'  => Dits::encodeDits($request->uuid_peserta)
        ];
        
        return Dits::sendResponse('success' , $data , 200 , 'set-ujian');
    }

    public function getSoal($kode_soal , $uuid_peserta) 
    {
        $kode_soal      = Dits::decodeDits($kode_soal);
        $uuid_peserta   = Dits::decodeDits($uuid_peserta);

        $soal           = Soal::where('kode_soal' , $kode_soal)->orderBy('nomor_soal' , 'ASC')->get();
        $bank_soal      = BankSoal::where('kode_soal' , $kode_soal)->first();

        $madrasah       = Madrasah::where('uuid' , $bank_soal->uuid_madrasah)->first();
        $pembukaan      = Pembukaan::where('uuid_madrasah' , $madrasah->uuid)
                                    ->where('status_pembukaan' , 'Dibuka')
                                    ->first();
        $pendaftaran    = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                    ->where('uuid_pembukaan' , $pembukaan->uuid)
                                    ->first();

        $imageSoal      = [];
        foreach($soal as $item) {
            array_push($imageSoal , [
                'image' => Dits::imageUrl($item->gambar)
            ]);
        }


        $data = [
            'soal' => $soal,
            'bank_soal' => $bank_soal,
            'pendaftaran'   => $pendaftaran,
        ];
        return Dits::sendResponse('success' , $data , 200 , 'get-soal');
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

    public function start($no , $kode_soal)
    {
        $kode_soal = json_decode($kode_soal);
        if(strlen($no) > 4) {
            $no = Dits::decodeDits($no);
        }

        $count_soal = Soal::where('kode_soal' , $kode_soal)->count();
        $no = intval($no);

        if ($no === $count_soal)
        {
            $finish = true;
        } else {
            $finish = false;
        }

        $soal   = Soal::where('kode_soal' , $kode_soal)
                        ->where('nomor_soal' , $no)
                        ->first();
        if(!$soal) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasuki halaman ujian, Soal tidak di temukan',
                'data' => '',
                'code' => 404
            ],404);
        }

        $navigasi = Soal::where('kode_soal' , $kode_soal)
                            ->orderBy('nomor_soal' , 'ASC')
                            ->get();

        $return_soal = $soal;
        $return_soal['is_gambar'] = $soal->gambar;
        $return_soal['gambar'] = Dits::imageUrl($soal->gambar);
        
        $data = [
            'no' => $no,
            'kode' => $kode_soal,
            'soal' => $return_soal,
            'navigasi' => $navigasi,
            'finish'  => $finish
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function storeJawaban(Request $request , $no , $kode_soal)
    {
        $no = Dits::decodeDits($no);
        $kode_soal = json_decode($kode_soal);

        $uuid_peserta = $request->uuid_login;

        $soal        = BankSoal::where('kode_soal' , $kode_soal)->first();
        $madrasah    = Madrasah::where('uuid' , $soal->uuid_madrasah)->first();
        $pembukaan   = Pembukaan::where('uuid_madrasah' , $madrasah->uuid)
                                    ->where('status_pembukaan' , 'Dibuka')
                                    ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                    ->where('uuid_pembukaan' , $pembukaan->uuid)
                                    ->first();
        if($request->jawaban) {
            $jawaban = $request->jawaban;
        } else {
            $jawaban = NULL;
        }

        $jawab = Soal::where('kode_soal' , $kode_soal)
                            ->where('nomor_soal' , $no)
                            ->first();
        if($jawaban == $jawab->kunci_jawaban) {
            $status_jawaban = 'Benar';
        } else {
            $status_jawaban = 'Salah';
        }
        
        $checkJawaban = Jawaban::where('kode_soal' , $kode_soal)
                                    ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                                    ->where('nomor_soal' , $no)
                                    ->first();

        if($checkJawaban) {
            $checkJawaban->update([
                'kode_soal'         => $kode_soal,
                'kode_pendaftaran'  => $pendaftaran->kode_pendaftaran,
                'nomor_soal'        => $no,
                'jawaban'           => $jawaban,
                'status_jawaban'    => $status_jawaban,
                'tgl_cat'           => Carbon::now()
            ]);
        } else {
            $store   = Jawaban::create([
                'uuid'              => Str::uuid(),
                'kode_soal'         => $kode_soal,
                'kode_pendaftaran'  => $pendaftaran->kode_pendaftaran,
                'nomor_soal'        => $no,
                'jawaban'           => $jawaban,
                'status_jawaban'    => $status_jawaban,
                'tgl_cat'           => Carbon::now()
            ]);
        }

        if($request->finish == true) {
            return response()->json([
                'status' => true,
                'data' => false,
                'message' => 'Ujian telah selesai'
            ], 200);
        }


        $data = [
            'next'    => Dits::encodeDits($no + 1)
        ];

        return response()->json([
            'data'  => $data
        ]);
    }

    public function jawaban($no , $kode_soal , $uuid_login) 
    {
        $uuid_peserta = $uuid_login;

        $kode_soal = json_decode($kode_soal);

        $no = Dits::decodeDits($no);

        $soal        = BankSoal::where('kode_soal' , $kode_soal)->first();
        $madrasah    = Madrasah::where('uuid' , $soal->uuid_madrasah)->first();
        $pembukaan   = Pembukaan::where('uuid_madrasah' , $madrasah->uuid)
                                    ->where('status_pembukaan' , 'Dibuka')
                                    ->first();
        $pendaftaran = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                    ->where('uuid_pembukaan' , $pembukaan->uuid)
                                    ->first();

        $checkJawaban = Jawaban::where('kode_soal' , $kode_soal)
                                ->where('kode_pendaftaran' , $pendaftaran->kode_pendaftaran)
                                ->where('nomor_soal' , $no)
                                ->first();

        return response()->json([
            'data' => $checkJawaban
        ]);
    }
}

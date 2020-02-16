<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\BankSoal;

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
        $uuid_peserta = \Auth::user()->uuid_login;
        $data = \App\Models\Peserta::where('uuid' , $uuid_peserta)->first();
        return view('pages.CAT.index' , compact('data'));
    }

    public function store(Request $request)
    {

        $minutes        = 90;

        // Set Cookie Ujian
        $cookie_name    = Dits::encodeDits('DitsUjian');
        $cookie_value   = json_encode($request->kode_ujian);
        Cookie::queue(Cookie::make($cookie_name, $cookie_value, $minutes));

        return redirect()->route('cat.start' , Dits::encodeDits(1));
    }

    public function start($no = 1)
    {
        
        if(strlen($no) > 4) {
            $no = Dits::decodeDits($no);
        }

        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);

        if (!$get_cookie) {
            toast('Gagal memasuki halaman ujian, Sesi sudah habis','error');
            return redirect()->route('cat.index');
        }
        $cookie_value =  json_decode($get_cookie , true);


        return view('pages.CAT.soal' , compact('no'));
    }

    public function storeJawaban(Request $request, $no)
    {
        $hashName   = Dits::encodeDits('kode_soal');
        $kode_soal  = Dits::decodeDits($request->$hashName);
        
        $next       = Dits::decodeDits($no) + 1;
        return redirect()->route('cat.start' , Dits::encodeDits($next));
    }

    public function end()
    {
        $minutes = 0.001;
        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);
        $cookie_value =  json_decode($get_cookie , true);

        if($cookie_value) {
            $unset_cookie = Cookie::queue(Cookie::make($cookie_name, $cookie_value, $minutes));
            if ($unset_cookie) {
                return redirect()->route('cat.index');
            }
            return redirect()->route('cat.end');
        }
        toast('Berhasil keluar dari halaman ujian','success');
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
         $data          = Operator::with('madrasah')
                                    ->where('uuid' , $uuid_operator)
                                    ->first();
         return view('pages.CAT.operator.create_edit' , compact('data'));
     }

     public function storeBank(Request $request)
     {
        $uuid_operator          = Auth::user()->uuid_login;
        $operator          = Operator::with('madrasah')
                                   ->where('uuid' , $uuid_operator)
                                   ->first();
        $kode_soal  = Dits::genKodeSoal('4');
        $bank_soal              = BankSoal::create([
                                    'uuid'          => Str::uuid(),
                                    'uuid_madrasah' => $operator->madrasah['uuid'],
                                    'uuid_operator'      => $uuid_operator,
                                    'kode_soal'     => $kode_soal,
                                    'status_bank_soal' => 'Aktif',
                                    'crash_session'    => 'No',
                                    'timer_cat'        => 90,
                                    'tgl_bank_soal'    => Carbon::now()
                                ]);
        if($bank_soal) {
            toast('Berhasil Menambah Bank Soal','success');
            return redirect()->route('bank-soal.index');
        }
     }

     public function data()
     {
         $data = BankSoal::with('madrasah')->get();

         return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                return '<a href="#" class="btn btn-dark btn-sm"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                            })
                            ->escapeColumns([])
                            ->make(true);
     }
}

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

class ArsipController extends Controller
{
    public function arsipPPDB($tahun)
    {
        return view('pages.ppdb.arsip.index' , compact('tahun'));
    }
    
    public function arsipPPDBData($tahun)
    {
        $uuid_operator = Auth::user()->uuid_login;
        if (Auth::user()->role == 'Operator Madrasah') {
            $data = Pembukaan::with('madrasah' , 'operator')
                                ->where('uuid_operator' , $uuid_operator)
                                ->whereYear('created_at',$tahun)
                                ->get();
        } else {
            $data = Pembukaan::with('madrasah' , 'operator')
                                ->whereYear('created_at',$tahun)
                                ->get();
        }
        
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="/buka-ppdb/detail/'.Dits::encodeDits($item->uuid).'" class="btn btn-dark btn-sm btn-block"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }

    public function arsipCAT($tahun)
    {
        return view('pages.CAT.arsip.index' , compact('tahun'));
    }

    public function arsipCATData($tahun)
     {
        $uuid_operator = Auth::user()->uuid_login;

        if (Auth::user()->role == 'Operator Madrasah') {
            $data = BankSoal::with('madrasah')
                            ->where('uuid_operator' , $uuid_operator)
                            ->whereYear('created_at',$tahun)
                            ->get();
        } else {
            $data = BankSoal::with('madrasah')
                            ->whereYear('created_at',$tahun)
                            ->get();
        }
         

         return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                return '<a href="/CAT/Bank/Soal/detail/'.Dits::encodeDits($item->uuid).'" class="btn btn-dark btn-sm"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                            })
                            ->escapeColumns([])
                            ->make(true);
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Exports\PendaftaranExport;
use \App\Imports\PengumumanImport;
use \App\Imports\SoalImport;

use Excel;
use Dits;
use Carbon\Carbon;
use Validator;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;


class ImportExportController extends Controller
{
    public function pendaftaranExport($id)
    {
        $uuid       = Dits::decodeDits($id);
        $pembukaan  = Pembukaan::with('madrasah')
                                ->whereUuid($uuid)
                                ->first();
                                // return $pembukaan;
        $date       = Carbon::now()->toDateTimeString();
        return Excel::download(new PendaftaranExport($uuid), 'export_ppdb_'.$pembukaan->nsm.$date.'.xlsx');
    }

    public function pengumumanImportView($id)
    {  
        $uuid = Dits::decodeDits($id);
        return view('imports.import-pengumuman' , compact('uuid'));
    }
    
    public function pengumumanImport(Request $request , $id)
    {
        Validator::make($request->all() , [
            'file_import' => 'required|max:1000|file|mimes:csv'
        ]);

        if($request->hasFile('file_import')) {
            Excel::import(new PengumumanImport , request()->file('file_import'), null, \Maatwebsite\Excel\Excel::CSV);
            toast('Berhasil Membuat Pengumuman','success');
            return back();
        }

    }

    public function soalImport(Request $request)
    { 
        $valid = Validator::make($request->all() , [
            'file_import' => 'required|max:1000|file|mimes:csv,xlsx'
        ]);

        if($request->hasFile('file_import')) {
            Excel::import(new SoalImport , request()->file('file_import'), null, \Maatwebsite\Excel\Excel::CSV);
            toast('Berhasil Membuat Soal','success');
            return back();
        } else {
            return 'adsasd';
        }
    }
}

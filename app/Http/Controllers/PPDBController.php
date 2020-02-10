<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;
use DataTables;
use Alert;
use Hash;

class PPDBController extends Controller
{
    public function listByID($id)
    {
        // $jenjang = Dits::decodeDits($id);

        return view('pages.ppdb.list' , compact('id'));
    }

    public function bukaPPDB()
    {
        return view('pages.ppdb.buka-ppdb');
    }

    public function create()
    {
        $madrasah = Madrasah::all();
        return view('pages.ppdb.create_edit' , compact('madrasah'));
    }

    public function store(Request $request)
    {
        $user  = Auth::user();
        $input = $request->all();
        if(!isset($request->uuid_madrasah)) {
            $operator      = Operator::whereUuidLogin($user->uuid_login)->first();
            $uuid_madrasah = $operator->uuid_madrasah;
        } else {
            $uuid_madrasah = Dits::decodeDits($request->uuid_madrasah);
            $operator      = Operator::whereUuidMadrasah($uuid_madrasah)->first();
            if(is_null($operator)) {
                toast('Gagal, Madrasah Yang Di Pilih Belum Mempunyai Operator','error');
                return back();
            }
        }
        $madrasah = Madrasah::whereUuid($uuid_madrasah)
                            ->first();
        $pembukaan = Pembukaan::whereUuidMadrasah($uuid_madrasah)
                                ->where('status_pembukaan' , 'Dibuka')
                                ->first();
        if($pembukaan != NULL) {
            toast('Gagal, Madrasah Yang Di Pilih Sedang Dibuka','error');
            return back();
        }

        $input['uuid']              = Str::uuid();
        $input['uuid_madrasah']     = $uuid_madrasah;
        $input['uuid_operator']     = $operator->uuid;
        $input['status_nomor']      = 'yes';
        $input['tgl_post']          = Carbon::now();
        $input['url_brosur']        = '';
        $input['status_pembukaan']  = 'Dibuka';

        if ($request->hasFile('url_brosur')){
            $fileName = Carbon::now()->timestamp. '.' . 
            $request->file('url_brosur')->getClientOriginalExtension();
            $uploadPdf = $request->file('url_brosur')->move(
                base_path() . '/public/document/brosur', $fileName
            );
            $input['url_brosur']    = $uploadPdf;
        }

        // return $input;
        
        $create     = Pembukaan::create($input);

        if ($create) {
            toast('Berhasil Membuat PPDB','success');
            return redirect()->route('buka-ppdb');
        }
        toast('Gagal, Membuat PPDB','error');
        return back();
    }

    public function detail($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::with('madrasah' , 'operator')
                            ->whereUuid($uuid)
                            ->first();
                            // return $data->madrasah;
        return view('pages.ppdb.detail' , compact('data'));
    }

    public function status($id)
    {
        $uuid       = Dits::decodeDits($id);
        $pembukaan  = Pembukaan::whereUuid($uuid)->first();
        if($pembukaan->status_pembukaan == 'Dibuka') {
            $pembukaan->update([
                'status_pembukaan' => 'Ditutup'
            ]);
            toast('Berhasil Memperbaharui Status Menjadi "Ditutup"','success');
            return back();
        } else {
            $pembukaan->update([
                'status_pembukaan' => 'Dibuka'
            ]);
            toast('Berhasil Memperbaharui Status Menjadi "Dibuka"','success');
            return back();
        }
        toast('Gagal Memperbaharui Status','error');
        return back();
    }

    public function data()
    {
        $data = Pembukaan::with('madrasah' , 'operator')->get();
        
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="/buka-ppdb/detail/'.Dits::encodeDits($item->uuid).'" class="btn btn-dark btn-sm btn-block"><i class="fas fa-cogs"></i> Opsi Lanjutan</a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }

    public function dataByID($id)
    {
        $jenjang = Dits::decodeDits($id);
        $data = Pembukaan::join('madrasahs' , 'madrasahs.uuid' , '=' , 'pembukaans.uuid_madrasah')
                            ->whereJenjang($jenjang)
                            ->get();
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="'.Dits::PdfViewer(asset($item->url_brosur)).'" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Brosur</a> ';
                                $btn .= '<a href="" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> ';
                                $btn .= '<a href="" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Daftar</a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }
}

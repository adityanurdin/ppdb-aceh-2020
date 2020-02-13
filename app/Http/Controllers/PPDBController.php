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

    public function daftar($id)
    {
        $uuid   = Dits::decodeDits($id);
        // return $uuid;
        $uuid_peserta = Auth::user()->uuid_login;

        // return $uuid_peserta;
        $check_pendaftaran = Pendaftaran::whereUuidPeserta($uuid_peserta)
                                            ->get('uuid_pembukaan');
                                            // return count($check_pendaftaran);
            if ( $check_pendaftaran->count() >= 3) {
                toast('Gagal, Kamu Sudah Mendaftar ke 3 Sekolah','error');
                return back();
            }
        $nomor_pendaftaran = Dits::interval('pendaftarans' , 'nomor_pendaftaran');
        $input  = array(
            'uuid'              => Str::uuid(),
            'uuid_pembukaan'    => $uuid,
            'uuid_peserta'      => $uuid_peserta,
            'kode_pendaftaran'  => Dits::generateCode(),
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'status_pendaftaran'=> 'Baru',
            'status_diterima'   => 'Tahap Seleksi',
            'jalur_diterima'    => '',
            'url_transfer'      => '',
            'status_transfer'   => '',
            'tgl_pendaftaran'   => Carbon::now()
        );

        $pendaftaran = Pendaftaran::create($input);

        if($pendaftaran)
        {
            toast('Berhasil Mendaftarkan Ke Sekolah yang Di Tuju','success');
            return back();
        }
        toast('Gagal Mendaftarkan Ke Sekolah yang Di Tuju','error');
        return back();
    }

    public function madrasahTerpilih()
    {
        return view('pages.ppdb.madrasah-terpilih');
    }

    public function madrasahTerpilihData()
    {
        $uuid = Auth::user()->uuid_login;
        $data = Pendaftaran::join('pembukaans' , 'pembukaans.uuid' , '=' , 'pendaftarans.uuid_pembukaan')
                            ->join('madrasahs' , 'madrasahs.uuid' , '=' , 'pembukaans.uuid_madrasah')
                            ->whereUuidPeserta($uuid)
                            ->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="'.Dits::PdfViewer(asset($item->url_brosur)).'" target="_blank" class="btn btn-danger btn-sm btn-block"><i class="fas fa-file-pdf"></i> Brosur</a>';
                                $btn .= '<a href="" class="btn btn-info btn-sm btn-block" ><i class="fas fa-eye"></i> Lihat</a>';
                                $btn .= '<a href="/ppdb/'.Dits::encodeDits($item->uuid_pembukaan).'/hapus" class="btn btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> Hapus</a>';
                                $btn .= '<a href="" class="btn btn-success btn-sm btn-block"><i class="fas fa-print"></i> Cetak</a>';
                                    if($item->status_diterima == 'Diterima') {
                                        $btn .= '<a href="#" class="btn btn-dark btn-sm btn-block"><i class="fas fa-coins"></i> Daftar Ulang</a>';
                                    }
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);

    }
    
    public function hapus($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $uuid_peserta  = Auth::user()->uuid_login;

        $pendaftaran    = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
                                        ->whereUuidPeserta($uuid_peserta)
                                        ->first();

        
        if($pendaftaran)
        {
            $pendaftaran->delete();
            toast('Berhasil Menghapus','success');
            return back();
        }
        toast('Gagal Menghapus','error');
        return back();
    }

    public function pengumuman($id , $kode = '')
    {
        $uuid = Dits::decodeDits($id);
        // return $uuid;
        $data = Pendaftaran::where('kode_pendaftaran' , $kode)
                                    ->first();
        return view('pages.ppdb.pengumuman.create_edit' , compact('id' , 'data'));
    }

    public function storePengumuman(Request $request , $id)
    {
        $uuid = Dits::decodeDits($id);
        $pendaftaran = Pendaftaran::where('kode_pendaftaran' , $request->kode_pendaftaran)
                                    ->first();
        if ($pendaftaran) {
            $pendaftaran->update([
                'status_diterima'   => $request->status_diterima,
                'jalur_diterima'    => $request->jalur_diterima
            ]);
            toast('Berhasil Membuat Pengumuman','success');
            return back();
        }
        toast('Gagal Membuat Pengumuman','error');
        return back();
    }
    
    public function updatePengumuman(Request $request , $id)
    {
        $uuid = Dits::decodeDits($id);
        // return $uuid;
        $pendaftaran = Pendaftaran::where('kode_pendaftaran' , $request->kode_pendaftaran)
                                    ->first();
                                    // return $pendaftaran;
        if ($pendaftaran) {
            $pendaftaran->update([
                'status_diterima'   => $request->status_diterima,
                'jalur_diterima'    => $request->jalur_diterima
            ]);
            toast('Berhasil Membuat Pengumuman','success');
            return back();
        }
        toast('Gagal Membuat Pengumuman','error');
        return back();
    }

    public function data()
    {
        $uuid_operator = Auth::user()->uuid_login;
        if (Auth::user()->role == 'Operator Madrasah') {
            $data = Pembukaan::with('madrasah' , 'operator')
                                ->where('uuid_operator' , $uuid_operator)
                                ->get();
        } else {
            $data = Pembukaan::with('madrasah' , 'operator')
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

    public function dataByID($id)
    {
        $jenjang = Dits::decodeDits($id);
        $data = Madrasah::join('pembukaans' , 'pembukaans.uuid_madrasah' , '=' , 'madrasahs.uuid')
                            ->whereJenjang($jenjang)
                            ->get();
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="'.Dits::PdfViewer(asset($item->url_brosur)).'" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Brosur</a> ';
                                $btn .= '<a href="" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a> ';
                                $btn .= '<a href="/ppdb/'.Dits::encodeDits($item->uuid).'/daftar" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Daftar</a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }
}

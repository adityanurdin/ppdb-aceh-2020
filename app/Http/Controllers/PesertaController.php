<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;
use DataTables;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePeserta(Request $request)
    {
        $uid    = Auth::user()->uuid_login;
        $input  = $request->all();


        $rule   = array(
            'nama'      => 'required',
            'NIK'       => 'required|integer',
            'nisn'      => 'required|integer',
            'tmp'       => 'required',
            'tgl'       => 'required',
            'jkl'       => 'required|',
            'agama'     => 'required',
            'hobi'      => 'required',
            'cita2'     => 'required',
            'anak_ke'   => 'required',
            'jml_saudara' => 'required',
            'alamat_rumah' => 'required',
            'sekolah_asal' => 'required',
            'npsn_sekolah_asal' => 'required|integer',
            'nama_sekolah_asal' => 'required',
            'alamat_sekolah_asal' => 'required',
            'yatim_piatu' => 'required',
            'nama_ayah' => 'required',
            'nik_ayah'  => 'required',
            'tmp_ayah'  => 'required',
            'tgl_ayah'  => 'required',
            'pekerjaan_ayah'  => 'required',
            'nama_ibu' => 'required',
            'nik_ibu'  => 'required',
            'tmp_ibu'  => 'required',
            'tgl_ibu'  => 'required',
            'pekerjaan_ibu'  => 'required',
            'kontak_peserta' => 'required|integer',
            'pas_foto' => 'required|image|mimes:jpeg,jpg,png|max:300'

        );

        $valid = Validator::make($request->all() , $rule);

        if($valid->fails()) {
            return $valid->errors();
        }

        $image = Dits::UploadImage($request , 'pas_foto' , 'pas_foto');
        $input['pas_foto']          = $image;
        $input['status_aktif']      = 'yes';
        $input['tgl_registrasi']    = Carbon::now();
        $input['nama']              = strtoupper($request->nama);

        $input['tgl']       =  Dits::ReplaceDate($request->tgl);
        $input['tgl_ayah']  =  Dits::ReplaceDate($request->tgl_ayah);
        $input['tgl_ibu']   =  Dits::ReplaceDate($request->tgl_ibu);

        $peserta = Peserta::whereUuid($uid)->first();
        $peserta->update($input);
        return redirect()->route('dashboard');
    }

    public function dataPesertaPPDB($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $data    = Pendaftaran::with('peserta')
                                        ->whereUuidPembukaan($uuid_pembukaan)
                                        ->whereStatusPendaftaran('Baru')
                                        ->get();
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="#" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a>';
                                $btn .= '<a href="/buka-ppdb/detail/'.Dits::encodeDits($item->uuid).'/update-status-pendaftaran/lolos" class="btn btn-sm btn-info btn-block"><i class="fas fa-check"></i> Lolos Dokumen</a>';
                                $btn .= '<a href="/buka-ppdb/detail/'.Dits::encodeDits($item->uuid).'/update-status-pendaftaran/tidak-lolos" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times"></i> Tidak Lolos Dokumen</a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make();
    }

    public function updateStatusPendaftaran($id , $status)
    {
        $uuid = Dits::decodeDits($id);
        $pendaftaran = Pendaftaran::whereUuid($uuid)
                                    ->first();
        
        if( $status == 'lolos' ) {
            $pendaftaran->update([
                'status_pendaftaran' => 'Lolos Tahap Dokumen'
            ]);
        } else if ( $status == 'tidak-lolos' ) {
            $pendaftaran->update([
                'status_pendaftaran' => 'Tidak Lolos Tahap Dokumen'
            ]);
        }

        if($pendaftaran) {
            toast('Berhasil Memperbaharui Status Pendaftaran','success');
            return back();
        } else {
            toast('Gagal Memperbaharui Status Pendaftaran','error');
            return back();
        }
    }
}

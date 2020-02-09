<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;

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
            'NIK'       => 'required|integer|unique:pesertas',
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
}

<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Image;
use Auth;
use Str;
use DB;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;

/**
 *  Create By : Muhammad Aditya Nurdin
 *  use       : Dits
 *  Date      : 05/02/2020
 *  Time      : 00:00
 *  Email     : adityanurdin0@gmail.com
 */

class Dits 
{

    public static function ImageName($path , $extension)
    {
        $fileName = Carbon::now()->timestamp;
        while(Storage::disk('public')->exists($path.$fileName.$extension)) {
            $fileName = Carbon::now()->timestamp;
        }

        return $path.$fileName.'.'.$extension;
    }

    public static function UploadImage(Request $request , $field , $path)
    {
        $file = $request->file($field);
        $path = $path.'/'.date('FY').'/';
        $full_path = Self::ImageName($path , $file->getClientOriginalExtension());

        $image = Image::make($file)->encode($file->getClientOriginalExtension(), 75);
        Storage::disk('public')->put($full_path, $image, 'public');

        return $full_path;
    }

    public static function ReplaceDate($tgl)
    {
        $tgl = str_replace('/', '-', $tgl);
        $tgl = date('Y-m-d', strtotime($tgl));

        return $tgl;
    }

    public static function DataPeserta()
    {
        $uid = Auth::user()->uuid_login;

        $peserta = Peserta::whereUuid($uid)->first();

        return $peserta;
    }

    public static function imageUrl($file, $default = 'https://simppdbaceh.frandikasepta.com/assets/img/logo-min.png'){
        if (!empty($file)) {
            return Storage::disk('public')->url($file);
        }

        return $default;
    }

    public static function decodeDits($encode)
    {
        $decode = base64_decode($encode);
        $result = substr($decode, 4);
        return $result;
    }

    public static function encodeDits($text)
    {
        $result = 'DITS'.$text;
        $encode = base64_encode($result);
        return $encode;
    }

    public static function BreadCrumb()
    {
        $path = \Request::path();
        
        if ($path == '/') {
            $result = '';
        }else {
            $result = str_replace('/' , ' / ' , $path);
        }
        return ucfirst($result);
    }

    public static function uploadFile(Request $request , $field , $path)
    {
        $file = $request->file($field);

        $path = $path.'/'.date('FY').'/';
        $full_path = Self::ImageName($path , $file->getClientOriginalExtension());

        $request->file($field)->move($full_path);

        return $full_path;
    }

    public static function PdfViewer($pdf)
    {
        $file   = str_replace(base_path().'/public/' , '/' , $pdf);
        return $file;
    }

    public static function generateCode()
    {
        $random = rand(123456 , 999999);
        $token  = bin2hex(random_bytes(2))."-".bin2hex(random_bytes(2));
        return strtoupper($token.$random);
    }

    public static function genKodeSoal($bytes)
    {
        return strtoupper(bin2hex(openssl_random_pseudo_bytes($bytes)));
    }

    public static function interval($table , $field , $int = 1 , $prefix = '')
    {
        // $id = MsAccident::max('id')+1;
        $id = DB::table($table)->max($field)+$int;
        $code = $prefix.$id;
        return $code;
    }

    public static function sendResponse($msg , $data = [] , $code = 200)
    {
        return response()->json([
            'status'    => true,
            'messages'  => $msg,
            'data'      => $data
        ]);
    }

    public static function checkJenjang()
    {
        $uuid_peserta = Auth::user()->uuid_login;
        if ($uuid_peserta) {
            $pendaftaran  = Pendaftaran::where('uuid_peserta' , $uuid_peserta)
                                            ->first();
            if ($pendaftaran) {
                $pembukaan    = Pembukaan::where('uuid' , $pendaftaran->uuid_pembukaan)
                                            ->first();
                if($pembukaan) {
                    $madrasah     = Madrasah::where('uuid' , $pembukaan->uuid_madrasah)
                                                ->first();
                    if($madrasah) {
                        $jenjang      = $madrasah->jenjang;
                        return $jenjang;
                    }
                    return 'no';
                }
                return 'no';
            }
            return 'no';
        }
        return 'no';
    }

    public static function hitungUmur($nik , $jkl)
    {
        if($jkl=="Perempuan"){
            $ambil_tgl = intval(substr($nik,6,2)-40);
            $ambil_bln = substr($nik,8,2);
            $ambil_thn = substr($nik,10,2);
            $tgl_nik = "20".$ambil_thn."-".$ambil_bln."-".$ambil_tgl;
            $tgl_nik = date('Y-m-d',strtotime($tgl_nik));
            return $tgl_nik;
        }else{
            $ambil_tgl = substr($nik,6,2);
            $ambil_bln = substr($nik,8,2);
            $ambil_thn = substr($nik,10,2);
            $tgl_nik = "20".$ambil_thn."-".$ambil_bln."-".$ambil_tgl;
            $tgl_nik = date('Y-m-d',strtotime($tgl_nik));
            return $tgl_nik;
        }
    }

    public static function cekLayak($umur)
    {
        if ($umur >= 6 && $umur == 7) { //MI
            return 'MI';
        } else if ($umur >= 12 && $umur <= 15) { //MTs
            return 'MTs';
        } else if ($umur >= 15 && $umur <= 21) { //MA
            return 'MA';
        } else { //error
            return 'no';
        }
    }

    public static function getCookieUjian()
    {
        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);

        if (!$get_cookie) {
            toast('Gagal memasuki halaman ujian, Sesi sudah habis','error');
            return redirect()->route('cat.index');
        }
        $cookie_value =  json_decode($get_cookie , true);

        return $cookie_value;
    }

    public static function selected($data , $value)
    {
        if ($data == $value) {
            $selected = 'selected';
        } else {
            $selected = '';
        }

        return $selected;
    }

    public static function countTableByWhere($model , $where_1 = '' , $where_1_value = '' , $where_2 = '' , $where_2_value = '' )
    {
        $table = $model::where($where_1 , $where_1_value)
                            ->where($where_2 , $where_2_value)
                            ->get()->count();
        return $table;
    }

    public static function ExpPersyaratan($data)
    {
        $data = explode(",", $data);
        return $data;
    }

    public static function DitsAdmin()
    {
        $username = 'admin';
        $password = bcrypt('1234');

        $check    = \App\User::where('role' , 'Admin System')->get();
        if($check) {
            return redirect()->route('home');
        }

        $user     = \App\User::create([
                    'uuid'     => \Str::uuid(),
                    'uuid_login' => '',
                    'username' => $username,
                    'email'    => 'adityanurdin0@gmail.com',
                    'password' => $password,
                    'img'      => '',
                    'role'     => 'Admin System'
                ]);
        if ($user) {
            toast('Berhasil Membuat User Admin','success');
            return redirect()->route('home');
        } else {
            return 'gagal';
        }
    }

    public static function cetakPendaftaran($nik , $id)
    {
        $uuid = \Dits::decodeDits($id);
        $data = \App\Models\Pendaftaran::with('peserta' , 'pembukaan')
                                        ->where('uuid' , $uuid)
                                        ->orWhere('kode_pendaftaran' , $uuid)
                                        ->first();
        $madrasah = \App\Models\Madrasah::where('uuid' , $data->pembukaan['uuid_madrasah'])->first();
        $persyaratan = explode(',' , $madrasah->persyaratan);
        return view('exports.cetak_pendaftaran' , compact('data' , 'madrasah' , 'persyaratan'));
    }

}


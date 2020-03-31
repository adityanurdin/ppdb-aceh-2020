<?php

namespace App\Helpers;

use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\User;
use Auth;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Image;
use Storage;
use Str;

/**
 *  Create By : Muhammad Aditya Nurdin
 *  use       : Dits
 *  Date      : 05/02/2020
 *  Time      : 00:00
 *  Email     : adityanurdin0@gmail.com
 */

class Dits
{

    public static function ImageName($path, $extension)
    {
        $fileName = Carbon::now()->timestamp;
        while (Storage::disk('public')->exists($path . $fileName . $extension)) {
            $fileName = Carbon::now()->timestamp;
        }

        return $path . $fileName . '.' . $extension;
    }

    public static function UploadImage(Request $request, $field, $path)
    {
        $file = $request->file($field);
        $path = $path . '/'. date('Y') . '/' . date('F') . '/';
        $full_path = Self::ImageName($path, $file->getClientOriginalExtension());

        $image = Image::make($file)->encode($file->getClientOriginalExtension(), 75);
        Storage::disk('public')->put($full_path, $image, 'public');

        return $full_path;
    }

    public static function UploadImageSoal(Request $request, $field, $path)
    {
        $file = $request->file($field);
        $path = 'Soal/'. date('Y') . '/' . $path . '/';
        $full_path = Self::ImageName($path, $file->getClientOriginalExtension());

        $image = Image::make($file)->encode($file->getClientOriginalExtension(), 75);
        Storage::disk('public')->put($full_path, $image, 'public');

        return $full_path;
    }

    public static function HapusImageSoal($path)
    {
        $exists = Storage::disk('public')->exists($path);
        if($exists){
            return Storage::disk('public')->delete($path);
        }
    }

    public static function HapusDocument($path)
    {
        $exists = Storage::disk('document')->exists($path);
        if($exists){
            return Storage::disk('document')->delete($path);
        }
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

    public static function imageUrl($file, $default = "")
    {
        if (!empty($file)) {
            return Storage::disk('public')->url($file);
        }

        return $default = asset('img/logo-min.png');
    }

    public static function decodeDits($encode)
    {
        $decode = base64_decode($encode);
        $result = substr($decode, 4);
        return $result;
    }

    public static function encodeDits($text)
    {
        $result = 'DITS' . $text;
        $encode = base64_encode($result);
        return $encode;
    }

    public static function BreadCrumb()
    {
        $path = \Request::path();

        if ($path == '/') {
            $result = '';
        } else {
            $result = str_replace('/', ' / ', $path);
        }
        return ucfirst($result);
    }

    public static function uploadFile(Request $request, $field, $path , $optionalPath = '')
    {
        /* $file = $request->file($field);

        $path = $path . '/' . date('FY') . '/';
        $full_path = Self::ImageName($path, $file->getClientOriginalExtension());

        $request->file($field)->move($full_path);

        return $full_path; */
        $fileName = Carbon::now()->timestamp . '.' .
        $request->file($field)->getClientOriginalExtension();
        $uploadPdf = $request->file($field)->move(
            base_path() . '/public/document/'.$path.'/'.date('Y') . '/' . $optionalPath , $fileName
        );
        return $uploadPdf;
    }

    // public static function PdfViewer($pdf)
    // {
    //     if (empty($pdf)) {
    //         return $pdf;
    //     }
    //     $file = str_replace(base_path() . '/public/', '/', $pdf);
    //     return $file;
    // }

    public static function PdfViewer($pdf)
    {
        if (empty($pdf)) {
            return $pdf;
        }
        $file = asset('storage/'.$pdf);
        return $file;
    }

    public static function generateCode()
    {
        $random = rand(123456, 999999);
        $token = bin2hex(random_bytes(2)) . "-" . bin2hex(random_bytes(2));
        return strtoupper($token . $random);
    }

    public static function genKodeSoal($bytes)
    {
        return strtoupper(bin2hex(openssl_random_pseudo_bytes($bytes)));
    }

    public static function interval($table, $uuid_pembukaan, $field, $int = 1, $prefix = '')
    {
        // $id = MsAccident::max('id')+1;
        $id = DB::table($table)->whereUuidPembukaan($uuid_pembukaan)->max($field) + $int;
        $code = $prefix . $id;
        return $code;
    }

    public static function sendResponse($msg, $data = [], $code = 200, $usage = '')
    {
        return response()->json([
            'status' => true,
            'messages' => $msg,
            'data' => $data,
            'usage' => $usage,
        ]);
    }

    public static function checkJenjang()
    {
        $uuid_peserta = Auth::user()->uuid_login;
        if ($uuid_peserta) {
            $pendaftaran = Pendaftaran::where('uuid_peserta', $uuid_peserta)
                ->first();
            if ($pendaftaran) {
                $pembukaan = Pembukaan::where('uuid', $pendaftaran->uuid_pembukaan)
                    ->first();
                if ($pembukaan) {
                    $madrasah = Madrasah::where('uuid', $pembukaan->uuid_madrasah)
                        ->first();
                    if ($madrasah) {
                        $jenjang = $madrasah->jenjang;
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

    public static function hitungUmur($nik, $jkl)
    {
        if ($jkl == "Perempuan") {
            $ambil_tgl = intval(substr($nik, 6, 2) - 40);
            $ambil_bln = substr($nik, 8, 2);
            $ambil_thn = substr($nik, 10, 2);
            $tgl_nik = "20" . $ambil_thn . "-" . $ambil_bln . "-" . $ambil_tgl;
            $tgl_nik = date('Y-m-d', strtotime($tgl_nik));
            return $tgl_nik;
        } else {
            $ambil_tgl = substr($nik, 6, 2);
            $ambil_bln = substr($nik, 8, 2);
            $ambil_thn = substr($nik, 10, 2);
            $tgl_nik = "20" . $ambil_thn . "-" . $ambil_bln . "-" . $ambil_tgl;
            $tgl_nik = date('Y-m-d', strtotime($tgl_nik));
            return $tgl_nik;
        }
    }

    public static function hitungUmurPerJuli()
    {
        $nik = Dits::DataPeserta()->NIK;
        $jkl = Dits::DataPeserta()->jkl;
        if ($jkl == "Perempuan") {
            $ambil_tgl = intval(substr($nik, 6, 2) - 40);
            $ambil_bln = substr($nik, 8, 2);
            $ambil_thn = substr($nik, 10, 2);
            $tgl_nik = "20" . $ambil_thn . "-" . $ambil_bln . "-" . $ambil_tgl;
            $tgl_nik = date('Y-m-d', strtotime($tgl_nik));
            $dateNow = date('Y') . "-07-01";
            $dateNow = date('Y-m-d', strtotime($dateNow));
            $date = new DateTime($tgl_nik);
            $now = new DateTime($dateNow);
            $interval = $now->diff($date);
            return $interval->y . " Tahun";
        } else {
            $ambil_tgl = substr($nik, 6, 2);
            $ambil_bln = substr($nik, 8, 2);
            $ambil_thn = substr($nik, 10, 2);
            $tgl_nik = "20" . $ambil_thn . "-" . $ambil_bln . "-" . $ambil_tgl;
            $tgl_nik = date('Y-m-d', strtotime($tgl_nik));
            $dateNow = date('Y') . "-07-01";
            $dateNow = date('Y-m-d', strtotime($dateNow));
            $date = new DateTime($tgl_nik);
            $now = new DateTime($dateNow);
            $interval = $now->diff($date);
            return $interval->y . " Tahun";
        }
    }

    public static function cekLayak($umur)
    {
        if($umur > 21){
            //error
            return 'no';
        }elseif($umur >= 15 && $umur <= 21){
            //MA
            return 'MA';
        }elseif($umur >= 11 && $umur <= 14){
            //MTs
            return 'MTs';
        }elseif($umur >= 6 && $umur <= 10){
            //MI
            return 'MI';
        }else{
            //error
            return 'no';
        }
    }

    public static function getCookieUjian()
    {
        $cookie_name = Dits::encodeDits('DitsUjian');
        $get_cookie = Cookie::get($cookie_name);

        if (!$get_cookie) {
            toast('Gagal memasuki halaman ujian, Sesi sudah habis', 'error');
            return redirect()->route('cat.index');
        }
        $cookie_value = json_decode($get_cookie, true);

        return $cookie_value;
    }

    public static function selected($data, $value, $option = 'selected')
    {
        if ($data == $value) {
            $selected = $option;
        } else {
            $selected = '';
        }

        return $selected;
    }

    public static function countTableByWhere($model, $where_1 = '', $where_1_value = '', $where_2 = '', $where_2_value = '')
    {
        $table = $model::where($where_1, $where_1_value)
            ->where($where_2, $where_2_value)
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

        $check = \App\User::where('role', 'Admin System')->first();
        if ($check) {
            return redirect()->route('home');
        }

        $user = \App\User::create([
            'uuid' => \Str::uuid(),
            'uuid_login' => '',
            'username' => $username,
            'email' => 'aditya@litecloud.id',
            'password' => $password,
            'img' => '',
            'role' => 'Admin System',
        ]);
        if ($user) {
            toast('Berhasil Membuat User Admin', 'success');
            return redirect()->route('home');
        } else {
            return 'gagal';
        }
    }

    public static function cetakPendaftaran($nik, $id)
    {
        $uuid = \Dits::decodeDits($id);
        $data = \App\Models\Pendaftaran::with('peserta', 'pembukaan')
            ->where('uuid', $uuid)
            ->orWhere('kode_pendaftaran', $uuid)
            ->first();
        $madrasah = \App\Models\Madrasah::where('uuid', $data->pembukaan['uuid_madrasah'])->first();
        $persyaratan = explode(',', $madrasah->persyaratan);
        return view('exports.cetak_pendaftaran', compact('data', 'madrasah', 'persyaratan'));
    }

}

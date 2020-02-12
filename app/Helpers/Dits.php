<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Image;
use Auth;
use Str;
use DB;

use App\Models\Peserta;

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


}


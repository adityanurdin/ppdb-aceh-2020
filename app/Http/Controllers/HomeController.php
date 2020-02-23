<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\Artikel;
use App\Models\Video;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;
use DataTables;
use Alert;
use Hash;

class HomeController extends Controller
{
    public function index()
    {
        $video = Video::where('status_video' , 'Publish')->orderBy('created_at' , 'Desc')->first();
        if(isset($video)) {
            $publisher = User::with('operator')->where('username' , $video->kode_user)->orderBy('created_at' , 'Desc')->first();
        }

        $artikel = Artikel::where('status_artikel' , 'Publish')->orderBy('created_at' , 'Desc')->limit(2)->get();
        
        return view('welcome' , compact('video' , 'publisher' , 'artikel'));
    }

    public function videos()
    {

        $video = Video::where('status_video' , 'Publish')->orderBy('created_at' , 'Desc')->get();
        foreach ($video as $item) {
            $publisher = User::with('operator')->where('username' , $item->kode_user)->orderBy('created_at' , 'Desc')->get();
        }
        return view('home.videos', compact('video' , 'publisher'));
    }

    public function artikel()
    {
        $artikel = Artikel::where('status_artikel' , 'Publish')->orderBy('created_at' , 'Desc')->get();
        foreach ($artikel as $item) {
            $publisher = User::with('operator')->where('username' , $item->kode_user)->orderBy('created_at' , 'Desc')->get();
        }
        return view('home.artikels', compact('artikel' , 'publisher'));
    }

    
}

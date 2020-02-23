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
        $video = Video::first();
        $publisher = User::with('operator')->where('username' , $video->kode_user)->first();
        return view('welcome' , compact('video' , 'publisher'));
    }
}

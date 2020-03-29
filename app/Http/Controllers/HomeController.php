<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Madrasah;
use App\Models\Video;
use App\User;
use Illuminate\Support\Facades\Schema;
use Str;

class HomeController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('users')) {
            //MIGRATE
            \Artisan::call('migrate');
            // CREATE USER
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
                'email' => 'admin@simppdbmadrasah.com',
                'password' => $password,
                'img' => '',
                'role' => 'Admin System',
            ]);
        }
        $mdr = Madrasah::all();
        return view('pages.home.beranda', compact('mdr'));
    }

    public function videos()
    {

        $video = Video::where('status_video', 'Publish')->orderBy('created_at', 'Desc')->paginate(3);
        return view('home.videos', compact('video'));
    }

    public function artikel()
    {
        $artikel = Artikel::where('status_artikel', 'Publish')->orderBy('created_at', 'Desc')->paginate(3);
        return view('home.artikels', compact('artikel'));
    }
}

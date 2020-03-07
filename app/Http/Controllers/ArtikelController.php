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

class ArtikelController extends Controller
{
    public function videoList()
    {
        return view('pages.artikel.video.index');
    }

    public function videoBySlug($slug)
    {
        $data = Video::where('slug_video' , $slug)->first();
        return view('pages.artikel.video.create_edit' , compact('slug' , 'data'));
    }

    public function videoSlug($slug)
    {
        $data = Video::where('slug_video' , $slug)->first();
        if(isset($data)) {
            $publisher = User::with('operator')->where('username' , $data->kode_user)->first();
        }
        return view('home.video' , compact('data' , 'publisher'));
    }

    public function create()
    {
        return view('pages.artikel.video.create_edit');
    }

    public function store(Request $request)
    {
        $uuid_operator = Auth::user()->uuid_login;
        $kode_video = Dits::genKodeSoal(4);
        $operator  = User::where('uuid_login' , $uuid_operator)->first();
        $kode_operator = $operator->username;

        $valid = Validator::make($request->all() , [
            'thumbnail_video' => 'image|mimes:jpeg,jpg,png|max:300'
        ]);

        if($valid->fails()) {
            toast('Gagal menambah video, Thumbnail video tidak sesuai','error');
            return back();
        }

        $slug = Str::slug($request->judul_video , '-');

        $input = $request->all();
        if($request->hasFile('thumbnail_video')) {
            $input['thumbnail_video'] = Dits::UploadImage($request , 'thumbnail_video' , 'thumbnail_video');
        }
        // $input['thumbnail_video'] = Dits::UploadImage($request , 'thumbnail_video' , 'thumbnail_video');
        $input['uuid']          = Str::uuid();
        $input['status_video']  = 'Publish';
        $input['slug_video']    = $slug;
        $input['kode_user']     = $kode_operator;
        $input['kode_video']    = $kode_video;
        // return $input;

        $create = Video::create($input);
        if ($create) {
            toast('Berhasil menambah video','success');
            return redirect()->route('video.list');
        }
        toast('Gagal menambah video','error');
        return back();
    }

    public function update(Request $request , $uuid)
    {
        $input = $request->all();

        if($request->hasFile('thumbnail_video')) {
            $input['thumbnail_video'] = Dits::UploadImage($request , 'thumbnail_video' , 'thumbnail_video');
        }

        $video = Video::whereUuid($uuid)->first();
        if ($video) {
            $video->update($input);
            toast('Berhasil memperbaharui video','success');
            return redirect()->route('video.list');
        }
    }

    public function changeStatus($uuid)
    {
        $video = Video::whereUuid($uuid)->first();
        if ($video->status_video == 'Publish') {
            $status = 'Draft';
        } else {
            $status = 'Publish';
        }
        if($video) {
            $video->update([
                'status_video' => $status
            ]);
            toast('Berhasil memperbaharui video','success');
            return redirect()->route('video.list');
        }
    }

    public function videoData()
    {
        $user = Auth::user();
        if($user->role == 'Admin System') {
            $data = Video::all();
        } else {
            $data = Video::where('kode_user' , $user->username)->get();
        }

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->editColumn('judul_video' , function($item) {
                                $link = '<a href="'.route('video.slug' , $item->slug_video).'"><u>'.substr($item->judul_video , 0 , 45).' ...</u></a>';
                                return $link;
                            })
                            ->addColumn('publisher' , function($item) {
                                $publisher = User::with('operator')->where('username' , $item->kode_user)->first();
                                return $publisher->operator['nama_operator'];
                            })
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="'.route('video.change-status' , $item->uuid).'" class="btn btn-dark btn-sm"><i class="fas fa-power-off"></i></a> ';
                                $btn .= '<a href="'.route('video.delete' , $item->uuid).'" onclick="return confirm_delete()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make();
    }

    public function artikelList()
    {
        return view('pages.artikel.index');
    }

    public function artikelBySlug($slug)
    {
        $data = Artikel::where('slug_artikel' , $slug)->first();
        return view('pages.artikel.create_edit' , compact('slug' , 'data'));
    }

    public function artikelSlug($slug)
    {
        $artikel = Artikel::where('slug_artikel' , $slug)->first();

        return view('home.artikel' , compact('artikel'));
    }

    public function ArtikelCreate()
    {
        return view('pages.artikel.create_edit');
    }

    public function ArtikelStore(Request $request)
    {
        $uuid_operator = Auth::user()->uuid_login;
        $kode_artikel = Dits::genKodeSoal(4);
        $operator  = User::where('uuid_login' , $uuid_operator)->first();
        $kode_operator = $operator->username;
        $input = $request->except(['files']);

        $valid = Validator::make($request->all() , [
            'thumbnail_artikel' => 'image|mimes:jpeg,jpg,png|max:300'
        ]);

        if($valid->fails()) {
            toast('Gagal menambah video, Thumbnail artikel tidak sesuai','error');
            return back();
        }

        $slug = Str::slug($request->judul_artikel , '-');

        if ($request->hasFile('thumbnail_artikel')) {
            $input['thumbnail_artikel'] = Dits::UploadImage($request , 'thumbnail_artikel' , 'thumbnail_artikel');
        }
        
        // $input['thumbnail_artikel'] = Dits::UploadImage($request , 'thumbnail_artikel' , 'thumbnail_artikel');
        $input['uuid']              = Str::uuid();
        $input['kode_artikel']      = $kode_artikel;
        $input['kode_user']         = $kode_operator;
        $input['slug_artikel']      = $slug;
        $input['status_artikel']    = 'Publish';

        $create = Artikel::create($input);
        if ($create) {
            toast('Berhasil menambah artikel','success');
            return redirect()->route('artikel.list');
        }
    }

    public function changeStatusArtikel($uuid)
    {
        $artikel = Artikel::whereUuid($uuid)->first();
        if ($artikel->status_artikel == 'Publish') {
            $status = 'Draft';
        } else {
            $status = 'Publish';
        }
        if($artikel) {
            $artikel->update([
                'status_artikel' => $status
            ]);
            toast('Berhasil memperbaharui artikel','success');
            return redirect()->route('artikel.list');
        }
    }

    public function updateArtikel(Request $request , $uuid)
    {
        $input = $request->all();

        if($request->hasFile('thumbnail_artikel')) {
            $input['thumbnail_artikel'] = Dits::UploadImage($request , 'thumbnail_artikel' , 'thumbnail_artikel');
        }

        $artikel = Artikel::whereUuid($uuid)->first();
        if ($artikel) {
            $artikel->update($input);
            toast('Berhasil memperbaharui artikel','success');
            return redirect()->route('artikel.list');
        }
    }

    public function artikelData()
    {
        $user = Auth::user();
        if($user->role == 'Admin System') {
            $data = Artikel::all();
        } else {
            $data = Artikel::where('kode_user' , $user->username)->get();
        }

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->editColumn('judul_artikel' , function($item) {
                                $link = '<a href="'.route('artikel.slug' , $item->slug_artikel).'"><u>'.substr($item->judul_artikel , 0 , 45).' ...</u></a>';
                                return $link;
                            })
                            ->addColumn('publisher' , function($item) {
                                $publisher = User::with('operator')->where('username' , $item->kode_user)->first();
                                return $publisher->operator['nama_operator'];
                            })
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="'.route('artikel.change-status' , $item->uuid).'" class="btn btn-dark btn-sm"><i class="fas fa-power-off"></i></a> ';
                                $btn .= '<a href="'.route('artikel.delete' , $item->uuid).'" onclick="return confirm_delete()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make();
    }
    
    public function deleteArtikel($uuid)
    {
        $data = Artikel::whereUuid($uuid)->first();
        if($data) {
            $data->delete();
            toast('Berhasil menghapus artikel','success');
            return redirect()->route('artikel.list');
        }
    }
    
    public function deleteVideo($uuid)
    {
        $data = Video::whereUuid($uuid)->first();
        if($data) {
            $data->delete();
            toast('Berhasil menghapus video','success');
            return redirect()->route('video.list');
        }
    }
}

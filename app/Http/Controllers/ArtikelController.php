<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Video;
use App\User;
use Auth;
use DataTables;
use Dits;
use Illuminate\Http\Request;
use Str;
use Validator;
use Image;
use Storage;

class ArtikelController extends Controller
{
    public function videoList()
    {
        return view('pages.artikel.video.index');
    }

    public function videoBySlug($slug)
    {
        $data = Video::where('slug_video', $slug)->first();
        return view('pages.artikel.video.create_edit', compact('slug', 'data'));
    }

    public function videoSlug($slug)
    {

        $video = Video::where('status_video', 'Publish')->where('slug_video', "!=", $slug)->orderBy('created_at', 'Desc')->limit(6)->get();
        $data = Video::where('slug_video', $slug)->first();
        $publisher = \App\User::where('username', $data->kode_user)->first();
        if ($publisher->role == "Admin System") {
            $nama = "Admin System";
        } else {
            $nama = $publisher->operator->nama_operator;
        }
        return view('home.video', compact('data', 'nama', 'video'));
    }

    public function create()
    {
        return view('pages.artikel.video.create_edit');
    }

    public function store(Request $request)
    {

        // Validation
        $request->validate([
            'judul_video' => 'required|string|max:300',
            'url_video' => 'required|string|max:100',
            'deskripsi_video' => 'sometimes|nullable|max:300',
        ]);

        $uuid_operator = Auth::user()->uuid_login;
        $kode_video = Dits::genKodeSoal(4);
        if (Auth::user()->role != 'Admin') {
            $operator = User::where('uuid_login', $uuid_operator)->first()->username;
        } else {
            $operator = 'admin';
        }
        $kode_operator = $operator;

        $valid = Validator::make($request->all(), [
            'thumbnail_video' => 'image|mimes:jpeg,jpg,png|max:300',
        ]);

        if ($valid->fails()) {
            toast('Gagal menambah video, Thumbnail video tidak sesuai', 'error');
            return back();
        }

        $slug = Str::slug($request->judul_video, '-');

        $input = $request->all();
        // if ($request->hasFile('thumbnail_video')) {
        //     // Upload File
        //     $ext = strtolower($request->file('thumbnail_video')->extension());
        //     $ext_array = Array('jpg','jpeg','png');
        //     if (in_array($ext, $ext_array)){
        //         $file = $request->file('thumbnail_video');
        //         $path_thumb = 'thumbnail/video/'.date('Y').'/'.date('F').'/';
        //         $file_name = $slug."-".rand(1000,9999999999).".jpg";
        //         $file_save = $path_thumb.$file_name;
        //         $resize = Image::make($file->getRealPath())->resize(700, 470);
        //         if(!is_dir(storage_path('app/public/'.$path_thumb))){
        //             Storage::disk('public')->makeDirectory($path_thumb);
        //         }
        //         $resize->save(storage_path('app/public/').$file_save, 60);
        //     } else {
        //         toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
        //         return back();
        //     }
        //     $input['thumbnail_video'] = $file_save;
        // }
        $input['uuid'] = Str::uuid();
        $input['status_video'] = 'Publish';
        $input['slug_video'] = $slug;
        $input['kode_user'] = $kode_operator;
        $input['kode_video'] = $kode_video;
        $input['thumbnail_video'] = "";
        // return $input;

        $create = Video::create($input);
        if ($create) {
            toast('Berhasil menambah video', 'success');
            return redirect()->route('video.list');
        }
        toast('Gagal menambah video', 'error');
        return back();
    }

    public function update(Request $request, $uuid)
    {
        $input = $request->all();
        $video = Video::whereUuid($uuid)->first();
        if ($video) {
            $video->update($input);
            toast('Berhasil memperbaharui video', 'success');
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
        if ($video) {
            $video->update([
                'status_video' => $status,
            ]);
            toast('Berhasil memperbaharui video', 'success');
            return redirect()->route('video.list');
        }
    }

    public function videoData()
    {
        $user = Auth::user();
        if ($user->role == 'Admin System') {
            $data = Video::all();
        } else {
            $data = Video::where('kode_user', $user->username)->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('judul_video', function ($item) {
                $link = '<a href="' . route('video.slug', $item->slug_video) . '"><u>' . substr($item->judul_video, 0, 45) . ' ...</u></a>';
                return $link;
            })
            ->addColumn('publisher', function ($item) {
                $publisher = User::with('operator')->where('username', $item->kode_user)->first();
                return $publisher->operator['nama_operator'];
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('video.change-status', $item->uuid) . '" class="btn btn-dark btn-sm"><i class="fas fa-power-off"></i></a> ';
                $btn .= '<a href="' . route('video.delete', $item->uuid) . '" onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
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
        $data = Artikel::where('slug_artikel', $slug)->first();
        return view('pages.artikel.create_edit', compact('slug', 'data'));
    }

    public function artikelSlug($slug)
    {
        $artikel = Artikel::where('status_artikel', 'Publish')->where('slug_artikel', "!=", $slug)->orderBy('created_at', 'Desc')->limit(6)->get();
        $data = Artikel::where('slug_artikel', $slug)->first();
        $publisher = \App\User::where('username', $data->kode_user)->first();
        if ($publisher->role == "Admin System") {
            $nama = "Admin System";
        } else {
            $nama = $publisher->operator->nama_operator;
        }
        return view('home.artikel', compact('data', 'nama', 'artikel'));
    }

    public function ArtikelCreate()
    {
        return view('pages.artikel.create_edit');
    }

    public function ArtikelStore(Request $request)
    {
        // Validation
        $request->validate([
            'judul_artikel' => 'required|string|max:300',
            'deskripsi_artikel' => 'required|string|max:300',
            'isi_artikel' => 'required|string|max:5000',
        ]);

        $uuid_operator = Auth::user()->uuid_login;
        $kode_artikel = Dits::genKodeSoal(4);
        if (Auth::user()->role != 'Admin') {
            $operator = User::where('uuid_login', $uuid_operator)->first()->username;
        } else {
            $operator = 'admin';
        }
        $kode_operator = $operator;
        $input = $request->except(['files']);

        $valid = Validator::make($request->all(), [
            'thumbnail_artikel' => 'image|mimes:jpeg,jpg,png|max:300',
        ]);

        if ($valid->fails()) {
            toast('Gagal menambah video, Thumbnail artikel tidak sesuai', 'error');
            return back();
        }

        $slug = Str::slug($request->judul_artikel, '-');

        if ($request->hasFile('thumbnail_artikel')) {
            // Upload File
            $ext = strtolower($request->file('thumbnail_artikel')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('thumbnail_artikel');
                $path_thumb = 'thumbnail/artikel/'.date('Y').'/'.date('F').'/';
                $file_name = $slug."-".rand(1000,9999999999).".jpg";
                $file_save = $path_thumb.$file_name;
                $resize = Image::make($file->getRealPath())->resize(700, 470);
                if(!is_dir(storage_path('app/public/'.$path_thumb))){
                    Storage::disk('public')->makeDirectory($path_thumb);
                }
                $resize->save(storage_path('app/public/').$file_save, 60);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
            $input['thumbnail_artikel'] = $file_save;
        }

        // $input['thumbnail_artikel'] = Dits::UploadImage($request , 'thumbnail_artikel' , 'thumbnail_artikel');
        $input['uuid'] = Str::uuid();
        $input['kode_artikel'] = $kode_artikel;
        $input['kode_user'] = $kode_operator;
        $input['slug_artikel'] = $slug;
        $input['status_artikel'] = 'Publish';

        $create = Artikel::create($input);
        if ($create) {
            toast('Berhasil menambah artikel', 'success');
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
        if ($artikel) {
            $artikel->update([
                'status_artikel' => $status,
            ]);
            toast('Berhasil memperbaharui artikel', 'success');
            return redirect()->route('artikel.list');
        }
    }

    public function updateArtikel(Request $request, $uuid)
    {
        $input = $request->all();

        $artikel = Artikel::whereUuid($uuid)->first();

        if ($request->hasFile('thumbnail_artikel')) {
            if($artikel->thumbnail_artikel!=""){
                if(Storage::disk('public')->exists($artikel->thumbnail_artikel)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($artikel->thumbnail_artikel);
                }
            }
            // Upload File
            $ext = strtolower($request->file('thumbnail_artikel')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('thumbnail_artikel');
                $path_thumb = 'thumbnail/artikel/'.date('Y').'/'.date('F').'/';
                $file_name = $artikel->slug_artikel."-".rand(1000,9999999999).".jpg";
                $file_save = $path_thumb.$file_name;
                $resize = Image::make($file->getRealPath())->resize(700, 470);
                if(!is_dir(storage_path('app/public/'.$path_thumb))){
                    Storage::disk('public')->makeDirectory($path_thumb);
                }
                $resize->save(storage_path('app/public/').$file_save, 60);
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
            $input['thumbnail_artikel'] = $file_save;
        }

        if ($artikel) {
            $artikel->update($input);
            toast('Berhasil memperbaharui artikel', 'success');
            return redirect()->route('artikel.list');
        }
    }

    public function artikelData()
    {
        $user = Auth::user();
        if ($user->role == 'Admin System') {
            $data = Artikel::all();
        } else {
            $data = Artikel::where('kode_user', $user->username)->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('judul_artikel', function ($item) {
                $link = '<a href="' . route('artikel.slug', $item->slug_artikel) . '"><u>' . substr($item->judul_artikel, 0, 45) . ' ...</u></a>';
                return $link;
            })
            ->addColumn('publisher', function ($item) {
                $publisher = User::with('operator')->where('username', $item->kode_user)->first();
                return $publisher->operator['nama_operator'];
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('artikel.change-status', $item->uuid) . '" class="btn btn-dark btn-sm"><i class="fas fa-power-off"></i></a> ';
                $btn .= '<a href="' . route('artikel.delete', $item->uuid) . '" onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make();
    }

    public function deleteArtikel($uuid)
    {
        $data = Artikel::whereUuid($uuid)->first();
        if ($data) {
            if($data->thumbnail_artikel!=""){
                if(Storage::disk('public')->exists($data->thumbnail_artikel)){
                    // Hapus thumbnail_artikel
                    Storage::disk('public')->delete($data->thumbnail_artikel);
                }
            }
            $data->delete();
            toast('Berhasil menghapus artikel', 'success');
            return redirect()->route('artikel.list');
        }
    }

    public function deleteVideo($uuid)
    {
        $data = Video::whereUuid($uuid)->first();
        if ($data) {
            if($data->thumbnail_video!=""){
                if(Storage::disk('public')->exists($data->thumbnail_video)){
                    // Hapus thumbnail_video
                    Storage::disk('public')->delete($data->thumbnail_video);
                }
            }
            $data->delete();
            toast('Berhasil menghapus video', 'success');
            return redirect()->route('video.list');
        }
    }
}

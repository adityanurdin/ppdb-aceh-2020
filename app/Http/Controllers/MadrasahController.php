<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Madrasah;
use App\Models\Operator;
use App\Models\Pembukaan;
use App\User;
use Auth;
use DataTables;
use Dits;
use Illuminate\Http\Request;
use Str;
use Validator;
use Image;
use Storage;

class MadrasahController extends Controller
{
    public function index()
    {
        return view('pages.database_madrasah.index');
    }

    public function create()
    {
        return view('pages.database_madrasah.create_edit');
    }

    public function store(Request $request)
    {

        // Validation
        $request->validate([
            "kode_satker" => "required|unique:madrasahs,kode_satker|string|max:100",
            "nsm" => "required|string|unique:madrasahs,nsm|max:100",
            "npsn" => "required|string|unique:madrasahs,npsn|max:100",
            "nama_madrasah" => "required|string|max:100",
            "alamat" => "required|string|max:300",
            "kelurahan" => "required|string|max:100",
            "kecamatan" => "required|string|max:100",
            "kabupaten" => "required|string|max:100",
            "provinsi" => "required|string|max:100",
            "email_madrasah" => "required|string|max:100",
            "kontak_madrasah" => "required|string|max:30",
            "preview" => "sometimes|nullable|string|max:1000",
        ]);

        $uuid = Str::uuid();
        $input = $request->except(['files']);
        $input['uuid'] = $uuid;
        $input['status'] = 'Negeri';
        $input['nama_madrasah'] = strtoupper($request->nama_madrasah);

        $valid = Validator::make($request->all(), [
            'logo_madrasah' => 'image|mimes:jpeg,jpg,png|max:300',
        ]);

        if ($valid->fails()) {
            toast('Gagal menambah soal, Logo madrasah tidak sesuai', 'error');
            return back();
        }

        if ($request->hasFile('logo_madrasah')) {
            // Upload Logo
            $ext = strtolower($request->file('logo_madrasah')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('logo_madrasah');
                $path_logo = 'logo-madrasah/'.date('Y').'/';
                $file_name = Str::slug(strtoupper($request->nama_madrasah),'-');
                $file_name = $file_name."-".rand(1000,9999999999).".jpg";
                $file_save = $path_logo.$file_name;
                $resize = Image::make($file->getRealPath())->resize(400, 400);
                if(!is_dir(storage_path('app/public/'.$path_logo))){
                    Storage::disk('public')->makeDirectory($path_logo);
                }
                $resize->save(storage_path('app/public/').$file_save, 60);
                $image = $file_save;
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
        } else {
            $image = null;
        }

        $input['logo_madrasah'] = $image;

        $madrasah = Madrasah::create($input);

        if ($madrasah) {
            toast('Berhasil menambah Madrasah', 'success');
            return redirect()->route('madrasah.index');
        } else {
            toast('Gagal menambah Madrasah', 'error');
            return redirect()->route('madrasah.index');
        }
    }

    public function edit($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Madrasah::whereUuid($uuid)->first();
        return view('pages.database_madrasah.create_edit', compact('data'));
    }

    public function editMadrasah()
    {
        $uuid = Auth::user()->uuid_login;
        $operator = Operator::where('uuid', $uuid)->first();
        $data = Madrasah::whereUuid($operator->uuid_madrasah)->first();
        // return $data;
        return view('pages.database_madrasah.create_edit', compact('data'));
    }

    public function operators_edit($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Operator::whereUuid($uuid)->first();
        return view('pages.database_madrasah.operators.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            "kode_satker" => "required|string|max:100",
            "nsm" => "required|string|max:100",
            "npsn" => "required|string|max:100",
            "nama_madrasah" => "required|string|max:100",
            "alamat" => "required|string|max:300",
            "kelurahan" => "required|string|max:100",
            "kecamatan" => "required|string|max:100",
            "kabupaten" => "required|string|max:100",
            "provinsi" => "required|string|max:100",
            "email_madrasah" => "required|string|max:100",
            "kontak_madrasah" => "required|string|max:30",
            "preview" => "sometimes|nullable|string|max:1000",
        ]);

        $uuid = Dits::decodeDits($id);
        $input = $request->all();
        $madrasah = Madrasah::whereUuid($uuid)->first();

        if ($request->hasFile('logo_madrasah')) {
            if($madrasah->logo_madrasah!=""){
                if(Storage::disk('public')->exists($madrasah->logo_madrasah)){
                    // Hapus logo_madrasah
                    Storage::disk('public')->delete($madrasah->logo_madrasah);
                }
            }
            // Upload Logo
            $ext = strtolower($request->file('logo_madrasah')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('logo_madrasah');
                $path_logo = 'logo-madrasah/'.date('Y').'/';
                $file_name = Str::slug(strtoupper($request->nama_madrasah),'-');
                $file_name = $file_name."-".rand(1000,9999999999).".jpg";
                $file_save = $path_logo.$file_name;
                $resize = Image::make($file->getRealPath())->resize(400, 400);
                if(!is_dir(storage_path('app/public/'.$path_logo))){
                    Storage::disk('public')->makeDirectory($path_logo);
                }
                $resize->save(storage_path('app/public/').$file_save, 60);
                $image = $file_save;
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
            $input['logo_madrasah'] = $image;
        }
        // return $input;
        $madrasah->update($input);
        if ($madrasah) {
            toast('Berhasil Memperbaharui Data', 'success');
            return back();
        } else {
            toast('Gagal Memperbaharui Data', 'error');
            return back();
        }
    }

    public function operators_update(Request $request, $id)
    {
        // Validation
        $request->validate([
            "nama_operator" => "required|string|max:100",
            "kontak_operator" => "required|string|max:30",
            "email_operator" => "required|email|max:100",
        ]);

        $uuid = Dits::decodeDits($id);
        $data = Operator::whereUuid($uuid)
            ->first();
        $data->update([
            'nama_operator' => $request->nama_operator,
            'kontak_operator' => $request->kontak_operator,
            'email_operator' => $request->email_operator,
        ]);

        if ($request->password) {
            // Validation
            $request->validate([
                "password" => "required|string|max:100",
            ]);
            $user = User::whereUuidLogin($uuid)->first();
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        if ($data) {
            toast('Berhasil memperbaharui data', 'success');
            return back();
        }
        toast('Gagal memperbaharui data', 'error');
        return back();
    }

    public function operators($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Madrasah::whereUuid($uuid)->first();
        return view('pages.database_madrasah.operators.index', compact('data'));
    }

    public function operators_store(Request $request, $id)
    {
        // Validation
        $request->validate([
            "nama_operator" => "required|string|max:100",
            "kontak_operator" => "required|string|max:30",
            "email_operator" => "required|email|unique:operators,email_operator|max:100",
        ]);

        $uuid_madrasah = Dits::decodeDits($id);
        $uuid = Str::uuid();
        $password = '1234';
        $OP_NAME = 'OP-' . rand(1, 5000);

        $madrasah = Madrasah::whereUuid($uuid_madrasah)->first();
        if (isset($madrasah->kode_satker)) {
            $satker = $madrasah->kode_satker;
        } else {
            $satker = null;
        }

        $operator = Operator::create([
            'uuid' => $uuid,
            'uuid_madrasah' => $uuid_madrasah,
            'satker' => $satker,
            'nama_operator' => $request->nama_operator,
            'kontak_operator' => $request->kontak_operator,
            'email_operator' => $request->email_operator,
        ]);

        $user = User::create([
            'uuid' => Str::uuid(),
            'uuid_login' => $uuid,
            'username' => $OP_NAME,
            'email' => $request->email_operator,
            'password' => bcrypt($password),
            'role' => 'Operator Madrasah',
            'status_aktif' => 'yes',
            'img' => '',
        ]);

        if ($user && $operator) {
            Alert::success('Berhasil Menambahkan Operator', 'Password ' . $OP_NAME . ' adalah : ' . $password);
            return back();
        }
        Alert::success('Gagal Menambahkan Operator');
        return back();

    }

    public function delete($id)
    {
        $id = Dits::decodeDits($id);
        $data = Operator::whereUuid($id)->first();
        $user = User::whereUuidLogin($id)->first();
        if ($data) {
            $data->delete();
            if ($user) {
                $user->delete();
            }
            toast('Berhasil menghapus Operator', 'success');
            return back();
        }
        toast('Gagal menghapus Operator', 'error');
        return back();
    }

    public function lockUnlock($id)
    {
        $id = Dits::decodeDits($id);
        $data = User::whereUuidLogin($id)->first();

        if ($data->status_aktif == 'yes') {
            $data->update([
                'status_aktif' => 'no',
            ]);
            if ($data) {
                toast('Berhasil mengunci Operator', 'success');
                return back();
            }
        } else {
            $data->update([
                'status_aktif' => 'yes',
            ]);
            if ($data) {
                toast('Berhasil membuka Operator', 'success');
                return back();
            }
        }

        toast('Gagal mengunci Operator', 'error');
        return back();
    }

    public function deleteMadrasah($id)
    {
        $id = Dits::decodeDits($id);
        $data = Madrasah::whereUuid($id)->first();
        $user = Operator::whereUuidMadrasah($id)->first();
        if ($user) {
            toast('Gagal menghapus Madrasah, Sudah Ada Operator!', 'error');
            return redirect()->route('madrasah.index');
        } else {
            if($data->logo_madrasah!=""){
                if(Storage::disk('public')->exists($data->logo_madrasah)){
                    // Hapus logo_madrasah
                    Storage::disk('public')->delete($data->logo_madrasah);
                }
            }
            $data->delete();
            toast('Berhasil menghapus Madrasah', 'success');
            return redirect()->route('madrasah.index');
        }
    }

    public function data()
    {
        $data = Madrasah::orderBy('nama_madrasah','ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . \env('APP_URL') . 'kemenag/madrasah/' . Dits::encodeDits($item->uuid) . '/edit" class="btn btn-warning btn-sm"><i class="fas fa-pen-square"></i></a> ';
                $btn .= '<a href="' . \env('APP_URL') . 'kemenag/madrasah/operators/' . Dits::encodeDits($item->uuid) . '" class="btn btn-info btn-sm mr-1"><i class="fas fa-users"></i></a>';
                $btn .= '<a href="' . \env('APP_URL') . 'kemenag/madrasah/' . Dits::encodeDits($item->uuid) . '/delete"  onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> ';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function operators_data($id)
    {
        $uuid_madrasah = Dits::decodeDits($id);
        $data = Operator::with('user')
            ->whereUuidMadrasah($uuid_madrasah)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                if ($item->user['status_aktif'] == 'yes') {
                    $status = '<a href="' . \env('APP_URL') . 'kemenag/madrasah/operator/' . Dits::encodeDits($item->uuid) . '/lockUnlock" class="btn btn-dark btn-sm"><i class="fas fa-lock"></i></a>';
                } else {
                    $status = '<a href="' . \env('APP_URL') . 'kemenag/madrasah/operator/' . Dits::encodeDits($item->uuid) . '/lockUnlock" class="btn btn-success btn-sm"><i class="fas fa-lock-open"></i></a>';
                }

                $btn = '<a href="' . \env('APP_URL') . 'kemenag/madrasah/operator/' . Dits::encodeDits($item->uuid) . '/delete" onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> ';
                $btn .= '<a href="' . \env('APP_URL') . 'kemenag/madrasah/operator/' . Dits::encodeDits($item->uuid) . '/edit" class="btn btn-warning btn-sm"><i class="fas fa-pen-square"></i></a> ';

                return $btn . $status;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function dokumen($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::where('uuid', $uuid)->first();
        $madrasah = Madrasah::where('uuid', $data->uuid_madrasah)->first();

        $persyaratan = explode(',', $madrasah->persyaratan);
        return view('pages.database_madrasah.operators.dokumen', compact('data', 'persyaratan', 'madrasah'));
    }

    public function dokumenStore(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Madrasah::where('uuid', $uuid)->first();
        if ($data) {
            $data->update([
                'persyaratan' => $request->persyaratan,
            ]);
            if ($data) {
                toast('Berhasil membuat persyaratan', 'success');
                return back();
            }
        }

    }
}

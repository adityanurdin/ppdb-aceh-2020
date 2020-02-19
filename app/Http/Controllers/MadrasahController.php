<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;

use Validator;
use Str;
use Auth;
use Carbon\Carbon;
use Dits;
use DataTables;
use Alert;
use Hash;

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
        $uuid   = Str::uuid();
        $input  = $request->all();
        $input['uuid'] = $uuid; 
        $input['status'] = 'Negeri';
        $input['nama_madrasah'] = strtoupper($request->nama_madrasah);

        if ($request->hasFile('logo_madrasah')) {
            $image = Dits::UploadImage($request , 'logo_madrasah' , 'Madrasah');
        } else {
            $image = NULL;
        }

        $input['logo_madrasah'] = $image;

        $madrasah = Madrasah::create($input);

        if($madrasah) {
            toast('Berhasil menambah Madrasah','success');
            return redirect()->route('madrasah.index');
        } else {
            toast('Gagal menambah Madrasah','error');
            return redirect()->route('madrasah.index');
        }
    }

    public function edit($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Madrasah::whereUuid($uuid)->first();
        return view('pages.database_madrasah.create_edit' , compact('data'));
    }

    public function operators_edit($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Operator::whereUuid($uuid)->first();
        return view('pages.database_madrasah.operators.edit' , compact('data'));
    }

    public function update(Request $request , $id)
    {
        $uuid   = Dits::decodeDits($id);
        $input  = $request->all();

        if($request->hasFile('logo_madrasah')) {
            $image = Dits::UploadImage($request , 'logo_madrasah' , 'Logo_Madrasah');
            $input['logo_madrasah'] = $image;
        }
        // return $input;
        $madrasah   = Madrasah::whereUuid($uuid)->first();
        $madrasah->update($input);
        // return $madrasah;
        if ($madrasah) {
            toast('Berhasil Memperbaharui Data','success');
            return redirect()->route('madrasah.index');
        } else {
            toast('Gagal Memperbaharui Data','error');
            return redirect()->route('madrasah.index');
        }   
    }

    public function operators_update(Request $request , $id)
    {
        $uuid   = Dits::decodeDits($id);
        $data   = Operator::whereUuid($uuid)
                            ->first();
        if(Hash::check($request->old_password, $data->user['password'])){
            $data->update([
                'nama_operator'     => $request->nama_operator,
                'kontak_operator'   => $request->kontak_operator,
                'email_operator'    => $request->email_operator
            ]);

            if($request->password) {
                $user = User::whereUuidLogin($id)->first();
                $user->update([
                    'password' => bcrypt($request->password)
                ]);
            }

            if($data) {
                toast('Berhasil memperbaharui data','success');
                return back();
            }
            toast('Gagal memperbaharui data','error');
            return back();
        }
        toast('Password lama salah','error');
        return back();
    }

    public function operators($id)
    {
        $uuid   = Dits::decodeDits($id);
        $data   = Madrasah::whereUuid($uuid)->first();
        return view('pages.database_madrasah.operators.index' , compact('data'));
    }

    public function operators_store(Request $request , $id)
    {
        $uuid_madrasah       = Dits::decodeDits($id);
        $uuid       = Str::uuid();
        $password   = '1234';
        $OP_NAME    = 'OP-'.rand(1 , 5000);

        $madrasah   = Madrasah::whereUuid($uuid_madrasah)->first();
        if(isset($madrasah->kode_satker)) {
            $satker = $madrasah->kode_satker;
        } else {
            $satker = NULL;
        }

        $operator = Operator::create([
            'uuid'              => $uuid,
            'uuid_madrasah'     => $uuid_madrasah,
            'satker'            => $satker,
            'nama_operator'     => $request->nama_operator,
            'kontak_operator'   => $request->kontak_operator,
            'email_operator'    => $request->email_operator
        ]);

        $user = User::create([
            'uuid'          => Str::uuid(),
            'uuid_login'    => $uuid,
            'username'      => $OP_NAME,
            'email'         => $request->email_operator,
            'password'      => bcrypt($password),
            'role'          => 'Operator Madrasah',
            'status_aktif'  => 'yes',
            'img'           => ''
        ]);

        if ($user && $operator) {
            Alert::success('Berhasil Menambahkan Operator', 'Password '.$OP_NAME.' adalah : '.$password);
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
            if( $data ) {
                $data->delete();
                if($user) {
                    $user->delete();
                }
                toast('Berhasil menghapus Operator','success');
                return back();
            }
        toast('Gagal menghapus Operator','error');
        return back();
    }

    public function lockUnlock($id)
    {
        $id = Dits::decodeDits($id);
        $data = User::whereUuidLogin($id)->first();
            
            if ($data->status_aktif == 'yes')
            {
                $data->update([
                    'status_aktif' => 'no'
                ]);
                if ($data) {
                    toast('Berhasil mengunci Operator','success');
                    return back();
                }
            } else {
                $data->update([
                    'status_aktif' => 'yes'
                ]);
                if ($data) {
                    toast('Berhasil membuka Operator','success');
                    return back();
                }
            }

        toast('Gagal mengunci Operator','error');
        return back();
    }

    public function data()
    {
        $data = Madrasah::all();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                $btn = '<a href="/kemenag/madrasah/'.Dits::encodeDits($item->uuid).'/edit" class="btn btn-warning btn-sm"><i class="fas fa-pen-square"></i></a> ';
                                $btn .= '<a href="/kemenag/madrasah/operators/'.Dits::encodeDits($item->uuid).'" class="btn btn-info btn-sm"><i class="fas fa-users"></i></a>';
                                return $btn;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }

    public function operators_data($id)
    {
        $uuid_madrasah       = Dits::decodeDits($id);
        $data = Operator::with('user')
                            ->whereUuidMadrasah($uuid_madrasah)
                            ->get();

        return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action' , function($item) {
                                if ($item->user['status_aktif'] == 'yes') {
                                    $status = '<a href="/kemenag/madrasah/operator/'.Dits::encodeDits($item->uuid).'/lockUnlock" class="btn btn-dark btn-sm"><i class="fas fa-lock"></i></a>';
                                } else {
                                    $status = '<a href="/kemenag/madrasah/operator/'.Dits::encodeDits($item->uuid).'/lockUnlock" class="btn btn-success btn-sm"><i class="fas fa-lock-open"></i></a>';
                                }
    
                                $btn = '<a href="/kemenag/madrasah/operator/'.Dits::encodeDits($item->uuid).'/delete"  onclick="return confirm("Yakin ingin menghapus '.$item->user['username'].'");" class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i></a> ';
                                $btn .= '<a href="/kemenag/madrasah/operator/'.Dits::encodeDits($item->uuid).'/edit" class="btn btn-warning btn-sm"><i class="fas fa-pen-square"></i></a> ';
                                $btn .= '<a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
    
                                return $btn.$status;
                            })
                            ->escapeColumns([])
                            ->make(true);
    }

    public function dokumen($id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pembukaan::where('uuid' , $uuid)->first();
        $madrasah = Madrasah::where('uuid' , $data->uuid_madrasah)->first();

        $persyaratan = explode(',' , $madrasah->persyaratan);
        return view('pages.database_madrasah.operators.dokumen' , compact('data' , 'persyaratan' , 'madrasah'));
    }

    public function dokumenStore(Request $request , $id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Madrasah::where('uuid' , $uuid)->first();
        if ($data) {
            $data->update([
                'persyaratan' => $request->persyaratan
            ]);
            if ($data) {
                toast('Berhasil membuat persyaratan','success');
                return back();
            }
        }

    }
}

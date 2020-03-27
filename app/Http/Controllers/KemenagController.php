<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Operator;
use App\User;
use DataTables;
use Dits;
use Illuminate\Http\Request;
use Str;

class KemenagController extends Controller
{
    public function index()
    {
        return view('pages.kemenag.index');
    }

    public function create()
    {
        return view('pages.kemenag.create_edit');
    }

    public function store(Request $request)
    {

        // Validation
        $request->validate([
            'nama_operator' => 'required|string|max:100',
            'kontak_operator' => 'required|string|max:30',
            'email_operator' => 'required|email|unique:users,email|max:100',
        ]);

        $uuid = Str::uuid();
        $password = '1234';
        $OP_NAME = 'OP-' . rand(1, 5000);

        $operator = Operator::create([
            'uuid' => $uuid,
            'nama_operator' => $request->nama_operator,
            'kontak_operator' => $request->kontak_operator,
            'email_operator' => strtolower($request->email_operator),
        ]);

        $user = User::create([
            'uuid' => Str::uuid(),
            'uuid_login' => $uuid,
            'username' => $OP_NAME,
            'email' => strtolower($request->email_operator),
            'password' => bcrypt($password),
            'role' => 'Operator Kemenag',
            'status_aktif' => 'yes',
            'img' => '',
        ]);

        if ($user && $operator) {
            Alert::success('Berhasil Menambahkan Operator', 'Password ' . $OP_NAME . ' adalah : ' . $password);
            return redirect()->route('kemenag.index');
        }
    }

    public function edit($id)
    {
        $id = Dits::decodeDits($id);
        $data = Operator::whereUuid($id)->first();
        return view('pages.kemenag.create_edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'nama_operator' => 'required|string|max:100',
            'kontak_operator' => 'required|string|max:30',
            'email_operator' => 'required|email|max:100',
            'old_password' => 'sometimes|nullable||min:4',
            'password' => 'sometimes|nullable||min:4',
        ]);

        $id = Dits::decodeDits($id);
        $data = Operator::whereUuid($id)->first();

        // Cek Jika Email Ganti
        if ($request->email_operator != $data->email_operator) {
            $request->validate([
                'email_operator' => 'required|email|unique:users,email|max:100',
            ]);
        }

        // Update Operator
        $operator = [
            'nama_operator' => $request->nama_operator,
            'kontak_operator' => $request->kontak_operator,
            'email_operator' => $request->email_operator,
        ];
        Operator::whereUuid($id)->update($operator);
        
        // Update Login
        $login = [
            'email' => $request->email_operator,
        ];
        User::whereUuidLogin($id)->update($login);

        // Cek Jika Password Ganti
        if ($request->has('password')) {
            $user = User::whereUuidLogin($id)->first();
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        if ($operator) {
            toast('Berhasil memperbaharui data', 'success');
            return redirect()->route('kemenag.index');
        }
        toast('Gagal memperbaharui data', 'error');
        return redirect()->route('kemenag.index');
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
                return redirect()->route('kemenag.index');
            }
        } else {
            $data->update([
                'status_aktif' => 'yes',
            ]);
            if ($data) {
                toast('Berhasil membuka Operator', 'success');
                return redirect()->route('kemenag.index');
            }
        }

        toast('Gagal mengunci Operator', 'error');
        return redirect()->route('kemenag.index');
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
            return redirect()->route('kemenag.index');
        }
        toast('Gagal menghapus Operator', 'error');
        return redirect()->route('kemenag.index');
    }

    public function data()
    {
        $data = User::join('operators', 'operators.uuid', '=', 'users.uuid_login')
            ->whereRole('Operator Kemenag')
            ->get();
        //  return $data;

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function ($item) {
                if ($item->status_aktif == 'yes') {
                    $status = '<a href="' . \env('APP_URL') . 'kemenag/' . Dits::encodeDits($item->uuid) . '/lockUnlock" class="btn btn-dark btn-sm"><i class="fas fa-lock"></i></a>';
                } else {
                    $status = '<a href="' . \env('APP_URL') . 'kemenag/' . Dits::encodeDits($item->uuid) . '/lockUnlock" class="btn btn-success btn-sm"><i class="fas fa-lock-open"></i></a>';
                }
                $btn = '<a href="' . \env('APP_URL') . 'kemenag/' . Dits::encodeDits($item->uuid) . '/delete"  onclick="return confirm(\'Anda Yakin Untuk Hapus Data Ini?\');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> ';
                $btn .= '<a href="' . \env('APP_URL') . 'kemenag/' . Dits::encodeDits($item->uuid) . '/edit" class="btn btn-warning btn-sm"><i class="fas fa-pen-square"></i></a> ';
                // $btn .= '<a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';

                return $btn . $status;
            })
            ->escapeColumns([])
            ->make(true);
    }
}

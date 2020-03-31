<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use App\Models\Peserta;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Str;

class AuthController extends Controller
{

    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'NIK' => 'required|string|max:16',
            'password' => 'required|string|min:4',
        ]);

        $credentials = [
            'username' => $request->NIK,
            'password' => $request->password,
        ];

        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            if (Auth::user()->status_aktif == 'no') {
                Auth::logout();
                toast('Status User Tidak Aktif', 'error');
                return redirect()->route('dashboard');
            }
            // toast('Berhasil Login','success');
            return redirect()->route('dashboard');
        } else {
            toast('NIK atau Password Salah !', 'error');
            return back();
        }
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'NIK' => 'required|string|unique:pesertas,NIK|max:16',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|confirmed|min:4',
        ]);

        $uuid_peserta = Str::uuid();

        if (strlen($request->NIK) < 16) {
            toast('NIK wajib 16 angka', 'error');
            return redirect()->route('auth.register');
        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'uuid_login' => $uuid_peserta,
            'username' => $request->NIK,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'status_aktif' => 'yes',
            'role' => 'Peserta',
            'img' => '',
        ]);

        $peserta = Peserta::create([
            'uuid' => $uuid_peserta,
            'NIK' => $request->NIK,
            'email' => $request->email,
            'status_aktif' => 'no',
        ]);

        if ($user && $peserta) {
            $credentials = [
                'username' => $request->NIK,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard');
            } else {
                return back();
            }
        } else {
            return 'gagal';
        }
    }

    public function akun()
    {
        $user = Auth::user();
        if ($user->role == "Operator Madrasah" || $user->role == "Operator Kemenag") {
            return view('pages.auth.akun_op', compact('user'));
        } else {
            return view('pages.auth.akun', compact('user'));
        }
    }

    public function updateAkun(Request $request)
    {
        $auth = Auth::user();
        if ($auth->role == "Operator Madrasah" || $auth->role == "Operator Kemenag") {
            // Validation
            $request->validate([
                "nama_operator" => "required|string|max:100",
                "kontak_operator" => "required|string|max:30",
                "email_operator" => "required|email|max:100",
            ]);
    
            $uuid = $auth->uuid_login;
            $data = Operator::whereUuid($uuid)->first();
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
                $user = User::whereUuid($auth->uuid)->first();
                if (password_verify($request->password, $user->password)) {
                    $user->update([
                        'password' => bcrypt($request->password_baru),
                    ]);
                }else{
                    toast('Gagal memperbaharui akun', 'error');
                    return back();
                }
            }
    
            if ($data) {
                toast('Berhasil memperbaharui akun', 'success');
                return back();
            }
            toast('Gagal memperbaharui akun', 'error');
            return back();
        } else {
            $user = User::whereUuid($auth->uuid)->first();
            if (password_verify($request->password, $user->password)) {
                $user->update([
                    'password' => bcrypt($request->password_baru),
                ]);
                toast('Berhasil Memperbaharui akun', 'success');
                return redirect()->route('dashboard');
            }
            toast('Gagal Memperbaharui akun, password salah', 'error');
            return back();
        }
    }

    public function lupas()
    {
        return view('pages.auth.lupas');
    }

    public function prosesLupas(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
        ]);

        $user = User::where('email', $request->email)->first();
        $password = Str::random(8);

        if ($user) {
            $details = [
                'password' => $password,
                'email' => $user->email,
            ];

            \Mail::to($user->email)->send(new \App\Mail\MailSender($details));

            $user->update([
                'password' => bcrypt($password),
            ]);

            toast('Berhasil mereset password, cek email atau email spam', 'success');
            return redirect()->route('home');
        }

        toast('Gagal mereset password', 'error');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        toast('Berhasil Keluar', 'success');
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use Dits;
use Image;
use Illuminate\Http\Request;
use Str;
use Storage;
use Validator;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePeserta(Request $request)
    {
        $uid = Auth::user()->uuid_login;
        $input = $request->all();

        $rule = array(
            'nama' => 'required',
            'NIK' => 'required|integer',
            'nisn' => 'required',
            'tmp' => 'required',
            'tgl' => 'required',
            'jkl' => 'required|',
            'agama' => 'required',
            'hobi' => 'required',
            'cita2' => 'required',
            'anak_ke' => 'required',
            'jml_saudara' => 'required',
            'alamat_rumah' => 'required',
            'sekolah_asal' => 'required',
            'npsn_sekolah_asal' => 'required',
            'nama_sekolah_asal' => 'required',
            'alamat_sekolah_asal' => 'required',
            'yatim_piatu' => 'required',
            'nama_ayah' => 'required',
            'nik_ayah' => 'required',
            'tmp_ayah' => 'required',
            'tgl_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'nik_ibu' => 'required',
            'tmp_ibu' => 'required',
            'tgl_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'kontak_peserta' => 'required',
            'email' => 'required',
        );

        $valid = Validator::make($request->all(), $rule);

        if ($valid->fails()) {
            return back()->withErrors($valid->errors());
        }

        $peserta = Peserta::whereUuid($uid)->first();

        if ($peserta->status_aktif == 'yes') {
            if ($request->NIK != Auth::user()->username) {
                toast('NIK tidak bisa di perbaharui !!', 'error');
                return back();
            }
        }

        if ($request->pas_foto) {
            $request->validate([
                'pas_foto' => 'required|image|mimes:jpeg,jpg,png|max:1000',
            ]);
            // Cek File Pas Foto
            if($peserta->pas_foto!=""){
                if(Storage::disk('public')->exists($peserta->pas_foto)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($peserta->pas_foto);
                }
            }
            // Upload Pas Foto
            $ext = strtolower($request->file('pas_foto')->extension());
            $ext_array = Array('jpg','jpeg','png');
            if (in_array($ext, $ext_array)){
                $file = $request->file('pas_foto');
                $path_PasFoto = 'peserta/'.date('Y').'/'.$request->NIK.'/pas-foto/';
                $file_name = Str::slug(strtoupper($request->nama),'-');
                $file_name = $file_name."-".rand(1000,9999999999).".jpg";
                $file_save = $path_PasFoto.$file_name;
                $resize = Image::make($file->getRealPath())->resize(300, 400);
                if(!is_dir(storage_path('app/public/'.$path_PasFoto))){
                    Storage::disk('public')->makeDirectory($path_PasFoto);
                }
                $resize->save(storage_path('app/public/').$file_save, 60);
                $input['pas_foto'] = $file_save;
            } else {
                toast('Gagal Upload Foto, Format File Tidak Diizinkan!', 'success');
                return back();
            }
        }
        $input['status_aktif'] = 'yes';
        $input['tgl_registrasi'] = Carbon::now();
        $input['nama'] = strtoupper($request->nama);

        $input['tgl'] = date('Y-m-d', strtotime($request->tgl));
        $input['tgl_ayah'] = date('Y-m-d', strtotime($request->tgl_ayah));
        $input['tgl_ibu'] = date('Y-m-d', strtotime($request->tgl_ibu));

        // Cek Jika Email Ganti
        if ($request->email != $peserta->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email|max:100',
            ]);
        }
        $input['email'] = strtolower($request->email);
        $login['email'] = $input['email'];

        $peserta->update($input);
        User::whereUuidLogin($uid)->update($login);
        toast('Berhasil memperbaharui data peserta', 'success');
        return redirect()->route('dashboard');
    }

    public function deletePhoto()
    {
        $uuid_peserta = Auth::user()->uuid_login;
        $peserta = Peserta::where('uuid', $uuid_peserta)->first();
        if ($peserta) {
            if($peserta->pas_foto!=""){
                if(Storage::disk('public')->exists($peserta->pas_foto)){
                    // Hapus Pas Foto
                    Storage::disk('public')->delete($peserta->pas_foto);
                }
            }
            $peserta->update([
                'pas_foto' => null,
            ]);
            toast('Berhasil Menghapus Pas Foto', 'success');
            return back();
        }
    }

    public function dataPesertaPPDB($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $data = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->orderBy('created_at', 'ASC')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nik', function ($item) {
                return $item->peserta->NIK;
            })
            ->addColumn('nama', function ($item) {
                return $item->peserta->nama;
            })
            ->addColumn('jkl', function ($item) {
                return $item->peserta->jkl;
            })
            ->addColumn('alamat_rumah', function ($item) {
                return $item->peserta->alamat_rumah;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('print.data', [$item->peserta->NIK, Dits::encodeDits($item->uuid)]) . '" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a>';
                if ($item->status_pendaftaran == 'Lolos Tahap Dokumen') {
                    $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/tidak-lolos" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times"></i> Tidak Lolos Dokumen</a>';
                } else if ($item->status_pendaftaran == 'Tidak Lolos Tahap Dokumen') {
                    $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/lolos" class="btn btn-sm btn-info btn-block"><i class="fas fa-check"></i> Lolos Dokumen</a>';
                } else {
                    $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/lolos" class="btn btn-sm btn-info btn-block"><i class="fas fa-check"></i> Lolos Dokumen</a>';
                    $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/tidak-lolos" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times"></i> Tidak Lolos Dokumen</a>';
                }
                if($item->pembukaan->madrasah->jenjang="MI"){
                    if ($item->peserta['akte'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['akte']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-eye"></i> Lihat Akte</a>';
                    }
                    if ($item->peserta['kk'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['kk']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-eye"></i> Lihat KK</a>';
                    }
                }
                if($item->pembukaan->madrasah->jenjang="MTs"){
                    if ($item->peserta['rapot_1'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_1']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls V SMT 1</a>';
                    }
                    if ($item->peserta['rapot_2'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_2']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls V SMT 2</a>';
                    }
                    if ($item->peserta['rapot_3'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_3']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VI SMT 1</a>';
                    }
                }
                if($item->pembukaan->madrasah->jenjang="MA"){
                    if ($item->peserta['rapot_4'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_4']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VII SMT 1</a>';
                    }
                    if ($item->peserta['rapot_5'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_5']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VII SMT 2</a>';
                    }
                    if ($item->peserta['rapot_6'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_6']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls IX SMT 2</a>';
                    }
                }
                return $btn;
            })
            ->escapeColumns([])
            ->make();
    }

    public function dataVerifikasi($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $data = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->whereStatusPendaftaran('Baru')
            ->orderBy('created_at', 'ASC')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nik', function ($item) {
                return $item->peserta->NIK;
            })
            ->addColumn('nama', function ($item) {
                return $item->peserta->nama;
            })
            ->addColumn('jkl', function ($item) {
                return $item->peserta->jkl;
            })
            ->addColumn('alamat_rumah', function ($item) {
                return $item->peserta->alamat_rumah;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('print.data', [$item->peserta->NIK, Dits::encodeDits($item->uuid)]) . '" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/lolos" class="btn btn-sm btn-info btn-block"><i class="fas fa-check"></i> Lolos Dokumen</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/update-status-pendaftaran/tidak-lolos" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times"></i> Tidak Lolos Dokumen</a>';
                if($item->pembukaan->madrasah->jenjang=="MI"){
                    if ($item->peserta['akte'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['akte']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-eye"></i> Lihat Akte</a>';
                    }
                    if ($item->peserta['kk'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['kk']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-eye"></i> Lihat KK</a>';
                    }
                }elseif($item->pembukaan->madrasah->jenjang=="MTs"){
                    if ($item->peserta['rapot_1'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_1']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls V SMT 1</a>';
                    }
                    if ($item->peserta['rapot_2'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_2']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls V SMT 2</a>';
                    }
                    if ($item->peserta['rapot_3'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_3']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VI SMT 1</a>';
                    }
                }elseif($item->pembukaan->madrasah->jenjang=="MA"){
                    if ($item->peserta['rapot_4'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_4']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VII SMT 1</a>';
                    }
                    if ($item->peserta['rapot_5'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_5']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls VII SMT 2</a>';
                    }
                    if ($item->peserta['rapot_6'] != null) {
                        $btn .= '<a href="' . Dits::pdfViewer($item->peserta['rapot_6']) . '" target="_blank" class="btn btn-sm btn-dark btn-block"><i class="fas fa-link"></i> Rapot Kls IX SMT 2</a>';
                    }
                }
                return $btn;
            })
            ->escapeColumns([])
            ->make();
    }

    public function dataDiterima($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $data = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->whereStatusDiterima('Diterima')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nik', function ($item) {
                return $item->peserta->NIK;
            })
            ->addColumn('nama', function ($item) {
                return $item->peserta->nama;
            })
            ->addColumn('jkl', function ($item) {
                return $item->peserta->jkl;
            })
            ->addColumn('alamat_rumah', function ($item) {
                return $item->peserta->alamat_rumah;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('print.data', [$item->peserta->NIK, Dits::encodeDits($item->uuid)]) . '" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/pengumuman/' . $item->kode_pendaftaran . '" class="btn btn-sm btn-info btn-block"><i class="fas fa-pencil-alt"></i> Edit Status</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make();
    }
    public function dataDitolak($id)
    {
        $uuid_pembukaan = Dits::decodeDits($id);
        $data = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->whereStatusDiterima('Ditolak')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nik', function ($item) {
                return $item->peserta->NIK;
            })
            ->addColumn('nama', function ($item) {
                return $item->peserta->nama;
            })
            ->addColumn('jkl', function ($item) {
                return $item->peserta->jkl;
            })
            ->addColumn('alamat_rumah', function ($item) {
                return $item->peserta->alamat_rumah;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="' . route('print.data', [$item->peserta->NIK, Dits::encodeDits($item->uuid)]) . '" target="_blank" class="btn btn-sm btn-success btn-block"><i class="fas fa-print"></i> Print / Cetak Data</a>';
                $btn .= '<a href="' . \env('APP_URL') . 'buka-ppdb/detail/' . Dits::encodeDits($item->uuid) . '/pengumuman/' . $item->kode_pendaftaran . '" class="btn btn-sm btn-info btn-block"><i class="fas fa-pencil-alt"></i> Edit Status</a>';
                return $btn;
            })
            ->escapeColumns([])
            ->make();
    }

    public function updateStatusPendaftaran($id, $status)
    {
        $uuid = Dits::decodeDits($id);
        $pendaftaran = Pendaftaran::whereUuid($uuid)
            ->first();

        if ($status == 'lolos') {
            $pendaftaran->update([
                'status_pendaftaran' => 'Lolos Tahap Dokumen',
            ]);
        } else if ($status == 'tidak-lolos') {
            $pendaftaran->update([
                'status_pendaftaran' => 'Tidak Lolos Tahap Dokumen',
            ]);
        }

        if ($pendaftaran) {
            toast('Berhasil Memperbaharui Status Pendaftaran', 'success');
            return back();
        } else {
            toast('Gagal Memperbaharui Status Pendaftaran', 'error');
            return back();
        }
    }

    public function dataDaftarUlang($id)
    {
        // $uuid = Dits::decodeDits($id);
        // $data = Pendaftaran::with('peserta')
        //     ->where('uuid_pembukaan', $uuid)->get();
        $uuid_pembukaan = Dits::decodeDits($id);
        $data = Pendaftaran::whereUuidPembukaan($uuid_pembukaan)
            ->whereStatusDiterima('Diterima')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function ($item) {
                return $item->peserta->nama;
            })
            ->addColumn('action', function ($item) {
                if ($item->url_transfer == '' || $item->url_transfer == null) {
                    $btn = '<a href="#" data-toggle="modal" data-target="#opsi-' . $item->uuid . '" class="btn btn-secondary disabled btn-sm btn-block" disabled><i class=" fa fa-bullhorn"></i> Verifikasi Pembayaran</a>';
                } else {
                    // $btn = '<a href="#" data-toggle="modal" data-target="#opsi-' . $item->uuid . '" class="btn btn-success btn-sm btn-block"><i class=" fa fa-bullhorn"></i> Verifikasi Pembayaran</a>';
                    $btn = '
                    <a class="btn btn-sm btn-success btn-block" href="javascript:void(0);" data-toggle="modal" onclick="vervalData(\'' . Dits::encodeDits($item->uuid) . '\',\'' . $item->peserta->nama . '\')"
                    data-target="#VervalModal" ><i class="fa fa-bullhorn"></i> Verifikasi Pembayaran</a>';
                }
                return $btn;
            })
            ->addColumn('file_transfer', function ($item) {
                if ($item->url_transfer == '' || $item->url_transfer == null) {
                    $btn = '<a href="' . Dits::pdfViewer($item->url_transfer) . '" target="_blink" class="btn btn-secondary btn-sm btn-block disabled" disabled><i class=" fa fa-eye"></i> Buka File</a>';
                } else {
                    $btn = '<a href="' . Dits::pdfViewer($item->url_transfer) . '" target="_blink" class="btn btn-warning btn-sm btn-block"><i class=" fa fa-eye"></i> Buka File</a>';
                }
                return $btn;
            })
            ->editColumn('status_transfer', function ($item) {
                if ($item->status_transfer == '' || $item->status_transfer == null) {
                    $result = 'Belum Transfer';
                } else {
                    $result = $item->status_transfer;
                }
                return $result;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function updateDaftarUlang(Request $request, $id)
    {
        $uuid = Dits::decodeDits($id);
        $data = Pendaftaran::where('uuid', $uuid)->first();
        if ($data) {
            $data->update([
                'status_transfer' => $request->status_transfer,
            ]);
            if ($data) {
                toast('Berhasil Memperbaharui Status Transfer', 'success');
                return back();
            }
            toast('Gagal Memperbaharui Status Transfer', 'error');
            return back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pembukaan;
use Carbon\Carbon;
use Dits;
use Excel;
use Illuminate\Http\Request;
use \App\Exports\PendaftaranExport;
use \App\Exports\PesertaUjianDetailExport;
use \App\Exports\pesertaUjianExport;
use \App\Exports\OperatorMadrasahExport;
use \App\Imports\JalurKhususImport;
use \App\Imports\JawabanImport;
use \App\Imports\PengumumanImport;
use \App\Imports\ResetAkunImport;
use App\Imports\ResetAkunOpImport;
use \App\Imports\SoalImport;

class ImportExportController extends Controller
{
    public function pendaftaranExport($id)
    {
        $uuid = Dits::decodeDits($id);
        $pembukaan = Pembukaan::with('madrasah')
            ->whereUuid($uuid)
            ->first();
        $date = Carbon::now()->toDateTimeString();
        return Excel::download(new PendaftaranExport($uuid), 'export_ppdb_' . $pembukaan->nsm . $date . '.xlsx');
    }

    public function pesertaUjianExport($id)
    {
        $date = Carbon::now()->toDateTimeString();
        return Excel::download(new PesertaUjianExport($id), 'export_ppdb_' . $id . $date . '.xlsx');
    }

    public function operatorExport()
    {
        $date = Carbon::now()->toDateTimeString();
        return Excel::download(new OperatorMadrasahExport(), 'export_op_madrasah_'. $date . '.xlsx');
    }

    public function pesertaUjianDetailExport($kode_pendaftaran, $kode_soal)
    {
        $date = Carbon::now()->toDateTimeString();
        return Excel::download(new PesertaUjianDetailExport($kode_soal, $kode_pendaftaran), 'export_ppdb_' . $kode_pendaftaran . $date . '.xlsx');
    }

    public function pengumumanImportView($id)
    {
        $uuid = Dits::decodeDits($id);
        return view('imports.import-pengumuman', compact('uuid'));
    }

    public function pengumumanImport(Request $request, $id)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        if ($request->hasFile('file_import')) {
            Excel::import(new PengumumanImport, request()->file('file_import'), null, \Maatwebsite\Excel\Excel::CSV);
            toast('Berhasil Membuat Pengumuman', 'success');
            return back();
        }

    }

    public function jawabanImport(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        if ($request->hasFile('file_upload')) {
            Excel::import(new jawabanImport(), request()->file('file_upload'));
            toast('Berhasil Upload Jawaban', 'success');
            return back();
        }
    }

    public function soalImport(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        // Kode Soal
        $kode_soal = $request->kode_soal;

        if ($request->hasFile('file_import')) {
            Excel::import(new SoalImport($kode_soal), request()->file('file_import'), null, \Maatwebsite\Excel\Excel::CSV);
            toast('Berhasil Membuat Soal', 'success');
            return back();
        } else {
            return back();
        }
    }

    public function jalurKhusus(Request $request, $id)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        $id = Dits::decodeDits($id);
        if ($request->hasFile('file_import')) {
            Excel::import(new JalurKhususImport($id), request()->file('file_import'), null, \Maatwebsite\Excel\Excel::CSV);
            toast('Berhasil Import Jalur Khusus!', 'success');
            return back();
        }
    }

    public function resetImport(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        if ($request->hasFile('file_upload')) {
            Excel::import(new ResetAkunImport(), request()->file('file_upload'));
            toast('Berhasil Reset Akun Peserta', 'success');
            return back();
        }
    }

    public function resetOpImport(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|file|mimes:csv,txt|max:1000',
        ]);

        if ($request->hasFile('file_upload')) {
            Excel::import(new ResetAkunOpImport(), request()->file('file_upload'));
            toast('Berhasil Reset Akun Peserta', 'success');
            return back();
        }
    }
}

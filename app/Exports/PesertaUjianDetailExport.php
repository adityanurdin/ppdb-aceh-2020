<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\User;
use App\Models\Operator;
use App\Models\Peserta;
use App\Models\Madrasah;
use App\Models\Pembukaan;
use App\Models\Pendaftaran;
use App\Models\Jawaban;
use Dits;

class PesertaUjianDetailExport implements FromView
{

    public function __construct($kode_soal , $kode_pendaftaran) 
    {
        $this->kode_soal = $kode_soal;
        $this->kode_pendaftaran = $kode_pendaftaran;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function view(): View
    {

        $jawaban = Jawaban::where('kode_soal' , $this->kode_soal)
                            ->where('kode_pendaftaran' , $this->kode_pendaftaran)
                            ->get();
        $pendaftaran = Pendaftaran::where('kode_pendaftaran' , $this->kode_pendaftaran)
                                        ->first();

        $peserta = Peserta::where('uuid' , $pendaftaran->uuid_peserta)
                            ->first();
        $kode_soal = $this->kode_soal;
        $kode_pendaftaran = $this->kode_pendaftaran;

        return view('exports.peserta_ujian_detail' , compact('jawaban' , 'peserta' , 'pendaftaran' , 'kode_soal' , 'kode_pendaftaran'));
    }
}

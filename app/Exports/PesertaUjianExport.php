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


class PesertaUjianExport implements FromView
{

    public function __construct($id) 
    {
        $this->id = $id;
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
        $id = $this->id;

        $data   = Jawaban::where('kode_soal' , $id)
                            ->groupBy('kode_pendaftaran')
                            ->get();
        
        $result = [];
        foreach($data as $item) {
            $pendaftaran = Pendaftaran::where('kode_pendaftaran' , $item->kode_pendaftaran)->first();
            $peserta     = Peserta::where('uuid' , $pendaftaran->uuid_peserta)->first();

            array_push($result, [
                'kode_pendaftaran'      => $item->kode_pendaftaran,
                'nomor_pendaftaran'     => $pendaftaran->nomor_pendaftaran,
                'nama_peserta'          => $peserta->nama,
                'jawab_benar'           => Jawaban::where('status_jawaban','Benar')
                                            ->where('kode_soal',$item->kode_soal)
                                            ->where('kode_pendaftaran',$item->kode_pendaftaran)
                                            ->count(),
                'jawab_salah'           => Jawaban::where('status_jawaban','Salah')
                                            ->where('kode_soal',$item->kode_soal)
                                            ->where('kode_pendaftaran',$item->kode_pendaftaran)
                                            ->count(),
                'tidak_jawab'           => Jawaban::where('status_jawaban','')
                                            ->where('kode_soal',$item->kode_soal)
                                            ->where('kode_pendaftaran',$item->kode_pendaftaran)
                                            ->count(),
            ]);
        }

        // dd($result[0]->kode+);

        return view('exports.peserta_ujian' , compact('data' , 'result' , 'id'));
    }
}

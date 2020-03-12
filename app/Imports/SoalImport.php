<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\Soal;


class SoalImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $item) 
        {
            $data = explode(';' ,$item[0]);
            try {
                Soal::create([
                    'uuid'          => \Str::uuid(),
                    'uuid_operator' => \Auth::user()->uuid_login,
                    'kode_soal'     => $data[0],
                    'jenis_soal'    => $data[1],
                    'nomor_soal'    => $data[2],
                    'soal'          => $data[3],
                    'gambar'        => NULL,
                    'a'             => $data[4],
                    'b'             => $data[5],
                    'c'             => $data[6],
                    'd'             => $data[7],
                    'kunci_jawaban' => strtolower($data[8]),
                    'tgl_soal'      => \Carbon\Carbon::now()
                ]);
            } catch (\Throwable $th) {
                return 'gagal';
            }
            
        }
    }
}

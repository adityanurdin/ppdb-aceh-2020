<?php

namespace App\Imports;

use App\Models\Soal;
use Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Str;

class SoalImport implements ToCollection
{
    public function __construct($kode_soal)
    {
        $this->kode_soal = $kode_soal;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $item) {
            // Data Explode
            $data = explode(';', $item);
            // Ambil Dari Data Pertama
            if ($i > 0 && $data[1] != "") {
                try {
                    Soal::create([
                        'uuid' => Str::uuid(),
                        'uuid_operator' => Auth::user()->uuid_login,
                        'kode_soal' => $this->kode_soal,
                        'jenis_soal' => \str_replace('["',"",$data[0]),
                        'nomor_soal' => $data[1],
                        'soal' => $data[2],
                        'a' => $data[3],
                        'b' => $data[4],
                        'c' => $data[5],
                        'd' => $data[6],
                        'kunci_jawaban' => \str_replace('"]',"",strtoupper($data[7])),
                        'tgl_soal' => \Carbon\Carbon::now(),
                    ]);
                } catch (\Throwable $th) {
                    return 'gagal';
                }
            }
            $i++;
        }
    }
}

<?php

namespace App\Imports;

use App\Models\Jawaban;
use App\Models\Soal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class JawabanImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $item) {
            $data = explode(';', $item[0]);
            $jawaban = Jawaban::where('kode_pendaftaran', $data[2])
                ->where('kode_soal', $data[1])
                ->where('nomor_soal', $data[3])
                ->first();
            $soal = Soal::where('kode_soal', $data[1])
                ->where('nomor_soal', $data[3])
                ->first();

            if ($data[4] == $soal->kunci_jawaban) {
                $status_jawaban = 'Benar';
            } elseif ($data[4] == '') {
                $status_jawaban = '';
            } else {
                $status_jawaban = 'Salah';
            }

            if ($jawaban) {
                $jawaban->update([
                    'jawaban' => $data[4],
                    'status_jawaban' => $status_jawaban,
                ]);
            }
        }
    }
}

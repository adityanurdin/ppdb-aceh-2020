<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Jawaban;

class JawabanImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $item) {
            $data = explode(';' ,$item[0]);
            $jawaban = Jawaban::where('kode_pendaftaran' , $data[2])
                                ->where('kode_soal' , $data[1])
                                ->where('nomor_soal' , $data[3])
                                ->first();
            if($jawaban) {
                $jawaban->update([
                    'jawaban' => $data[4]
                ]);
            }
        }
    }
}

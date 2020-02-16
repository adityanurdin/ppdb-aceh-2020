<?php

namespace App\Imports;

use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\Pendaftaran;

class PengumumanImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // foreach ($rows as $row)
        // {
            $pendaftaran = Pendaftaran::where('kode_pendaftaran' , $row[0])
                        // ->first()
                        ->update([
                            'status_diterima'   => $row[0],
                            'jalur_diterima'    => $row[0]
                        ]);
            return $pendaftaran;
        // }
    }
}

<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\Pendaftaran;

class PengumumanImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $item) 
        {
            $data = explode(';' ,$item[0]);
            if($data[1]=="Diterima"){
                try {
                    Pendaftaran::where('kode_pendaftaran' , $data[0])->update([
                        'status_pendaftaran'   => "Lolos Tahap Dokumen",
                        'status_diterima'   => $data[1],
                        'jalur_diterima'    => $data[2]
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }else{
                try {
                    Pendaftaran::where('kode_pendaftaran' , $data[0])->update([
                        'status_diterima'   => $data[1],
                        'jalur_diterima'    => $data[2]
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }
    }
}

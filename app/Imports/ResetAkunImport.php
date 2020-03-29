<?php

namespace App\Imports;

use App\Models\Pendaftaran;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResetAkunImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $item) {
            $data = explode(';', $item[0]);
            $pendaftaran = Pendaftaran::where('kode_pendaftaran', $data[0])->first();
            if ($pendaftaran) {
                User::whereUuidLogin($pendaftaran->uuid_peserta)->update([
                    'password' => bcrypt($data[1]),
                ]);
            }
        }
    }
}

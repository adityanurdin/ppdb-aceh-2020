<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResetAkunOpImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $item) {
            $data = explode(';', $item[0]);
            $op = User::where('username', $data[0])->where('role','Operator Madrasah')->first();
            if ($op) {
                $op->update([
                    'password' => bcrypt($data[1]),
                ]);
            }
        }
    }
}

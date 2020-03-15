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
use Dits;

class PendaftaranExport implements FromView
{

    public function __construct($uuid) 
    {
        $this->uuid = $uuid;
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
        $uuid = $this->uuid;
        $pembukaan  = Pembukaan::with('madrasah')
                                ->whereUuid($uuid)
                                ->first();
        /* $data = Pendaftaran::join('pembukaans' , 'pembukaans.uuid' , '=' , 'pendaftarans.uuid_pembukaan')
                            ->join('madrasahs' , 'madrasahs.uuid' , '=' , 'pembukaans.uuid_madrasah')
                            ->join('pesertas' , 'pesertas.uuid' , '=' , 'pendaftarans.uuid_peserta')
                            // ->where('uuid',$uuid)
                            ->get(); */
        $data   = Pembukaan::join('madrasahs' , 'madrasahs.uuid' , '=' , 'pembukaans.uuid_madrasah')
                            ->join('pendaftarans' , 'pendaftarans.uuid_pembukaan' , '=' , 'pembukaans.uuid')
                            ->join('pesertas' , 'pesertas.uuid' , '=' , 'pendaftarans.uuid_peserta')
                            ->where('uuid_madrasah' , $pembukaan->uuid_madrasah)
                            ->get();
        // dd($data);
        return view('exports.pendaftaran' , [
            'data'  => $data
        ]);
    }
}

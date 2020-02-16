<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];

    public function peserta()
    {
        return $this->belongsTo('App\Models\Peserta', 'uuid_peserta', 'uuid');
    }

    public function pembukaan()
    {
        return $this->belongsTo('App\Models\Pembukaan', 'uuid_pembukaan' , 'uuid');
    }
}

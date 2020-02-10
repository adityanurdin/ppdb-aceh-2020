<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembukaan extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];

    public function madrasah()
    {
        return $this->belongsTo('App\Models\Madrasah' , 'uuid_madrasah' , 'uuid');
    }

    public function operator()
    {
        return $this->belongsTo('App\Models\Operator' , 'uuid_operator' , 'uuid');
    }
}

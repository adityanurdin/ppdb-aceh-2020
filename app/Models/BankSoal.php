<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];

    public function madrasah()
    {
        return $this->belongsTo('App\Models\Madrasah', 'uuid_madrasah', 'uuid');
    }
}

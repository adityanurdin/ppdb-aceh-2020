<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];

    public function getGambarAttribute()
    {
        return \Dits::imageUrl($this->attributes['gambar']);
    }
}

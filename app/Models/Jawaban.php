<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];
}

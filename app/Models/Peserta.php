<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];
    
    // protected $fillable = [
    //     'uuid', 'uuid_login', 'username', 'email', 'password', 'role','status_aktif'
    // ];

}

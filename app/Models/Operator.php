<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    public $incrementing = false;
    protected $primaryKey = "uuid";
    protected $guarded = [];
    
    // protected $fillable = [
    //     'uuid', 'uuid_login', 'username', 'email', 'password', 'role','status_aktif'
    // ];

    public function user()
    {
        return $this->belongsTo('App\User', 'uuid' , 'uuid_login');
    }

}

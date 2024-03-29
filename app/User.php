<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    public $incrementing = false;
    protected $primaryKey = "uuid";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'uuid_login', 'username', 'email', 'password', 'role', 'status_aktif', 'img'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function operator()
    {
        return $this->belongsTo('App\Models\Operator' , 'uuid_login' , 'uuid');
    }
    
    public function peserta()
    {
        return $this->belongsTo('App\Models\Peserta' , 'uuid_login' , 'uuid');
    }
}

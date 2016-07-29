<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table        = 'sys_user_mst';
    protected $primaryKey   = 'f_nip_sys';
    public $incrementing    = false;
    public $timestamps      = false;
    // protected $keyType      = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_nip_sys', 'name', 'email', 'password', 'sys_user_created', 'sys_user_updated', 'sys_tgl_created', 'sys_tgl_updated', 'sys_status_aktif',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}

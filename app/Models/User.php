<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;

    protected $connection = 'publication';

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'pasword', 'remember_token', 'phone'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //超级管理员
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    //系统配置 可选角色
    public function getSystemRoles()
    {
        return $this->isSuperAdmin() ? Role::all() : Role::where('name', '<>', 'super-admin')->get();
    }
}

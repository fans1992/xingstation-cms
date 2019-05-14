<?php

namespace App\Models;

use App\Http\Controllers\Work\V1\Models\Work;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Material\V1\Models\Material;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use HybridRelations;

    protected $connection = 'publication';

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'pasword', 'remember_token', 'phone'
    ];

    protected $visible = [
        'id', 'name', 'phone', 'email', 'avatar'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    //超级管理员
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    //普通管理员
    public function isAdmin()
    {
        return $this->hasRole(['super-admin', 'admin']);
    }

    //系统配置 可选角色
    public function getSystemRoles()
    {
        return $this->isSuperAdmin() ? Role::all() : Role::where('name', '<>', 'super-admin')->get();
    }

    //素材
    public function materials()
    {
        return $this->hasMany(Material::class, 'user_id', 'id');
    }

    //作品
    public function works()
    {
        return $this->hasMany(Work::class, 'user_id', 'id');
    }
}

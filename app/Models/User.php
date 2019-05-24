<?php

namespace App\Models;

use App\Http\Controllers\Work\V1\Models\Work;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Material\V1\Models\Material;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $password
 * @property string|null $weixin_openid
 * @property string|null $weixin_unionid
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property string|null $introduction
 * @property int|null $ar_user_id 星视度用户ID
 * @property string|null $z ar用户标识
 * @property int $notification_count
 * @property string|null $tower_access_token
 * @property string|null $tower_refresh_token
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Http\Controllers\Material\V1\Models\Material[] $materials
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Http\Controllers\Work\V1\Models\Work[] $works
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|User newModelQuery()
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereArUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTowerAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTowerRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWeixinOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWeixinUnionid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereZ($value)
 * @mixin \Eloquent
 */
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

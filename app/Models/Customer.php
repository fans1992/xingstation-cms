<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Customer
 *
 * @package App\Models
 * @property int $id
 * @property int $company_id
 * @property string $name 客户名称
 * @property string|null $position 职务
 * @property string|null $phone
 * @property string|null $telephone 座机电话
 * @property string|null $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property string|null $introduction
 * @property int $notification_count
 * @property string|null $weixin_openid
 * @property string|null $weixin_unionid
 * @property int|null $ar_user_id 星视度用户ID
 * @property string|null $z ar用户标识
 * @property string|null $deleted_at
 * @property-read \App\Http\Controllers\Common\V1\Models\Company $company
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Http\Controllers\Admin\Privilege\V1\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Http\Controllers\Admin\Privilege\V1\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereArUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereWeixinOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereWeixinUnionid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereZ($value)
 * @mixin \Eloquent
 */
class Customer extends Authenticatable implements JWTSubject
{
    use HasRoles;

    protected $guard_name = 'shop';

    protected $fillable = ['name', 'position', 'phone', 'telephone', 'company_id', 'password','z'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    //CMS管理员
    public function isAdmin()
    {
        return $this->hasRole('cms_admin');
    }
}

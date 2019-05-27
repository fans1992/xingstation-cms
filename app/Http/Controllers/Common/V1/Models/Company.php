<?php

namespace App\Http\Controllers\Common\V1\Models;

use App\Http\Controllers\Media\V1\Models\Media;
use App\Models\User;
use App\Models\Model;

/**
 * App\Http\Controllers\Common\V1\Models\Company
 *
 * @property int $id
 * @property int $user_id
 * @property string $name 公司全称
 * @property string|null $internal_name
 * @property string $address 公司地址
 * @property int|null $parent_id
 * @property int $category 0:客户，1：供应商
 * @property string $status 1待审核 2.待合作 3合作中 4已结束
 * @property int $trade_id
 * @property int|null $bd_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description 商户描述
 * @property string $logo 商户logo
 * @property int|null $logo_media_id
 * @property-read \App\Http\Controllers\Media\V1\Models\Media|null $media
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model recent()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBdUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereInternalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 * @mixin \Eloquent
 */
class Company extends Model
{

    protected $fillable = ['name', 'internal_name', 'address', 'category','status', 'user_id', 'trade_id', 'bd_user_id','parent_id', 'description', 'logo', 'logo_media_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'logo_media_id', 'id');
    }
}

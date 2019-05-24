<?php

namespace App\Http\Controllers\Admin\Common\V1\Models;

use App\Models\Model;
use App\Models\User;

/**
 * App\Http\Controllers\Admin\Common\V1\Models\Image
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model recent()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUserId($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    protected $fillable = ['type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Http\Controllers\Admin\Common\V1\Models;

use App\Models\Model;

class Image extends Model
{
    protected $fillable = ['type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Http\Controllers\Admin\Media\V1\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;

class Media extends Model
{
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'type',
        'size',
        'url',
        'company_id',
        'height',
        'width',
    ];

}
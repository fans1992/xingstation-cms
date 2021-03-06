<?php

namespace App\Http\Controllers\Material\V1\Models;

use App\Models\User;
use Moloquent;

class Material extends Moloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'materials';

    protected $primaryKey = '_id';

    protected $casts = [
        '_id' => 'string'
    ];

    protected $guarded = ['_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

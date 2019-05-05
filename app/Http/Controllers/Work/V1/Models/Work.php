<?php

namespace App\Http\Controllers\Work\V1\Models;

use App\Models\User;
use Moloquent;

class Work extends Moloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'works';

    protected $primaryKey = '_id';

    protected $casts = [
        '_id' => 'string'
    ];

    public $fillable = [
        'coms',
        'pages',
        'settings',
    ];

//    protected $guarded = ['_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

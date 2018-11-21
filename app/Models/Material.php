<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Material extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'xingstation_cms';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'detail'
//    ];
}
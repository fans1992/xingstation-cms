<?php

namespace App\Http\Controllers\Material\V1\Models;

use Moloquent;

class Material extends Moloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'materials';

}

<?php

namespace App\Http\Controllers\Work\V1\Transformer;

use App\Http\Controllers\User\V1\Transformer\UserTransformer;
use App\Http\Controllers\Work\V1\Models\Work;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class WorkTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Work $work)
    {
        return [
            '_id' => $work->_id
        ];
    }

    public function includeUser(Work $work)
    {
        if (!$work->user) {
            return null;
        }

        return $this->item($work->user, new UserTransformer());
    }
}
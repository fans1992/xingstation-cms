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
            '_id' => $work->_id,
//            'user_id' => $work->user_id,
            'title' => $work->status['project']['title'],
            'coverUrl' => $work->status['project']['coverUrl'],
//            'name' => $work->name,
//            'status' => $work->﻿status,
//            'comList' => $work->﻿comList,
//            'pageList' => $work->﻿pageList,
//            'created_at' => $work->created_at->toDateTimeString(),
//            'updated_at' => $work->updated_at->toDateTimeString(),
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
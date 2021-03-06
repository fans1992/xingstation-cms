<?php

namespace App\Http\Controllers\Material\V1\Transformer;

use App\Http\Controllers\Material\V1\Models\Material;
use App\Http\Controllers\User\V1\Transformer\UserTransformer;
use League\Fractal\TransformerAbstract;

class MaterialTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Material $material)
    {
        return [
//            '_id' => $material->_id,
////            'user_id' => $material->user_id,
//            'name' => $material->name,
//            'type' => $material->type,
//            'created_at' => $material->created_at->toDateTimeString(),
//            'updated_at' => $material->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Material $material)
    {
        if(!$material->user){
            return null;
        }

        return $this->item($material->user, new UserTransformer());
    }
}
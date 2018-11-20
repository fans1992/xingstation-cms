<?php

namespace App\Http\Controllers\Admin\Media\V1\Transformer;

use League\Fractal\TransformerAbstract;
use App\Http\Controllers\Admin\Media\V1\Models\Media;

class MediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'company_id' => $media->company_id,
            'name' => $media->name,
            'type' => $media->type,
            'size' => $media->size,
            'url' => $media->url,
            'height' => $media->height,
            'width' => $media->width,
            'created_at' => $media->created_at->toDateTimeString(),
            'updated_at' => $media->updated_at->toDateTimeString(),
        ];
    }
}
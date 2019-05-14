<?php

namespace App\Http\Controllers\Media\V1\Api;

use App\Http\Controllers\Media\V1\Transformer\MediaTransformer;
use App\Http\Controllers\Media\V1\Models\Media;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class MediaController extends Controller
{
    public function store(Request $request, Media $media)
    {
        $disk = \Storage::disk('qiniu');

        //移动到指定路径
        $path = $request->get('folder') . '/' .$request->get('key');
        $disk->move($request->get('key'), $path);

        $domain = $disk->getDriver()->downloadUrl();
        $data = [
            'name' => $request->get('name'),
            'url' => $domain . urlencode($path),
            'size' => $request->get('size'),
            'height' => 0,
            'width' => 0,
        ];
        $media->fill($data)->save();
        return $this->response()->item($media, new MediaTransformer())->setStatusCode(201);
    }

}

<?php

namespace App\Http\Controllers\Media\V1\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Media\V1\Request\MediaRequest;
use Illuminate\Http\Request;
use Image;

class MediaController extends Controller
{
    public function store(MediaRequest $request, ImageUploadHandler $uploader)
    {
        /** @var  $file \Illuminate\Http\UploadedFile */
        $file = $request->file;

        $url = $uploader->save($file, "cms/" . str_plural($request->type));

        return $this->response->array([
            'url' => $url,
        ])->setStatusCode(201);
    }

}

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
        $user = $this->user();

        $companyID = $user->company_id;
        $ar_user_id = $user->ar_user_id;
        /** @var  $file \Illuminate\Http\UploadedFile */
        $file = $request->file;

        $width = 0;
        $height = 0;

        if ($request->type == 'image') {
            $image = Image::make($file);
            $height = $image->height();
            $width = $image->width();
        }

        $url = $uploader->save($file, "ads/$ar_user_id/" . str_plural($request->type));

        $data = [
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
            'url' => $url,
            'company_id' => $companyID,
            'height' => $height,
            'width' => $width,
        ];

        $media->fill(array_merge($data, $request->all()))->save();

        return $this->response->item($media, new MediaTransformer());
    }

}

<?php

namespace App\Http\Controllers\Admin\Media\V1\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Admin\Media\V1\Request\MediaRequest;
use App\Http\Controllers\Admin\Media\V1\Models\Media;
use App\Http\Controllers\Admin\Media\V1\Transformer\MediaTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class MediaController extends Controller
{

    public function index(MediaRequest $request, Media $media)
    {
        $query = $media->query();
        $query->where('type', $request->type);
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $media = $query->paginate(10);

        return $this->response->paginator($media, new MediaTransformer());
    }

    public function store(MediaRequest $request, Media $media, ImageUploadHandler $uploader)
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

    public function update(MediaRequest $request, Media $media)
    {
        $media->fill($request->only('name'))->update();
        return $this->response->item($media, new MediaTransformer());
    }

    public function destroy(MediaRequest $request)
    {
        $companyID = $this->user()->company_id;
        foreach ($request->ids as $id) {
            Media::query()->where('id', $id)->where('company_id', $companyID)->delete();
        }

        return $this->response->noContent();
    }
}

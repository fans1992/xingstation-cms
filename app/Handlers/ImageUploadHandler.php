<?php

namespace App\Handlers;

use Log;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg', 'mp4'];

    public function save($file, $file_prefix)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        $disk = \Storage::disk('qiniu');
        $result = $disk->put($filename, fopen($file, 'r'));
        Log::info('qi niu url', ['result' => $result]);

        return $disk->getDriver()->downloadUrl($filename)->getUrl();
    }

}
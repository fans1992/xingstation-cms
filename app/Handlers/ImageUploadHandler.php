<?php

namespace App\Handlers;

use Log;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg', 'mp4', 'wmv'];

    public function save($file, $file_prefix)
    {
        /** @var  $file \Illuminate\Http\UploadedFile */
        $format = $file->getClientOriginalExtension();
        if (!in_array($format, $this->allowed_ext)) {
            abort(500, "不支持" . $format . "文件格式");
        }
        $extension = strtolower($format);
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        $disk = \Storage::disk('qiniu');
        $result = $disk->put($filename, fopen($file, 'r'));
        Log::info('qi niu url', ['result' => $result]);

        return $disk->getDriver()->downloadUrl($filename)->getUrl();
    }

}
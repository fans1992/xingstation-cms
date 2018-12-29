<?php

namespace App\Http\Controllers\Common\V1\Api;

use App\Http\Controllers\Controller;

class QiniuController extends Controller
{
    public function oauth()
    {
        $disk = \Storage::disk('qiniu');
        $token = $disk->getDriver()->uploadToken();
        return $token;
    }
}
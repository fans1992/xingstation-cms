<?php

namespace App\Http\Controllers\Admin\Common\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Request\CaptchaRequest;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchaController extends Controller
{
    public function store(CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-' . str_random(15);

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(5);

        \Cache::put($key, ['code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}

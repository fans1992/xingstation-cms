<?php

namespace App\Http\Controllers\Common\V1\Api;

use App\Http\Controllers\Common\V1\Request\CaptchaRequest;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $phone = $request->phone;

        $key = 'captcha-' . str_random(15);

        /**
         * 保护短信接口 不被代理IP攻击
         */
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}

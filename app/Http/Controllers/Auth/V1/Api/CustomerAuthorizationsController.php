<?php

namespace App\Http\Controllers\Auth\V1\Api;

use App\Http\Controllers\Auth\V1\Request\CustomerAuthorizationRequest;
use App\Http\Controllers\Controller;
use Auth;

class CustomerAuthorizationsController extends Controller
{
    public function store(CustomerAuthorizationRequest $request)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if (!$captchaData) {
            return $this->response->error('图片验证码已失效', 422);
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }

        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('customer')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        $user = Auth::guard('customer')->user();
        activity('login')->causedBy($user)->log('登陆成功');

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('customer')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    /**
     * 在可刷新的时间范围内，换取新token(旧token过期也可以)
     * @return mixed
     */
    public function update()
    {
        $token = Auth::guard('customer')->refresh();
        return $this->respondWithToken($token);
    }

    /**
     * 删除token，用户退出登录，将当前token禁用
     * 返回204 无需返回内容
     * @return mixed
     */
    public function destroy()
    {
        Auth::guard('customer')->logout();
        activity('logout')->causedBy($this->user())->log('用户登出');
        return $this->response->noContent();
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('customer')->factory()->getTTL() * 60
        ]);
    }

}

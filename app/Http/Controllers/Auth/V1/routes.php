<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Auth\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\Customer'], function ($api) {
            $api->put('authorizations/current', 'AuthorizationsController@update');// 刷新token
            $api->delete('authorizations/current', 'AuthorizationsController@destroy');// 删除token
            $api->post('password/reset', 'ResetPasswordController@reset');//修改密码

        });
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        //管理员登陆
        $api->post('authorizations', 'AuthorizationsController@store');

        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store');
    });

});
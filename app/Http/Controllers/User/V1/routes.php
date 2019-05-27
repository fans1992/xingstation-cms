<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\User\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        $api->get('user', 'UsersController@me');

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\Customer'], function ($api) {

            //当前登录用户信息
            $api->get('user', 'UsersController@me');
            $api->patch('user', 'UsersController@update');//patch 部分修改资源，提供部分资源信息
        });
    });

});
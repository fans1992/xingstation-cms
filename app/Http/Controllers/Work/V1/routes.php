<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Work\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\User'], function ($api) {

            //作品列表
            $api->get('works', 'WorksController@index');

            //发布作品
            $api->post('works', 'WorksController@store');

            //查看作品
            $api->get('works/{work}', 'WorksController@show');

            //修改作品
            $api->put('works/{work}', 'WorksController@update');

            //删除作品
            $api->delete('works/{work}', 'WorksController@destroy');

        });

    });

});
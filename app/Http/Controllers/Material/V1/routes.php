<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Material\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\User'], function ($api) {

            //素材列表
            $api->get('materials', 'MaterialsController@index');

            //上传素材
            $api->post('materials', 'MaterialsController@store');

            //查看素材
            $api->get('materials/{material}', 'MaterialsController@show');

            //修改素材
            $api->put('materials/{material}', 'MaterialsController@update');

            //删除素材
            $api->delete('materials/{material}', 'MaterialsController@destroy');

            //我的素材
            $api->get('users/{user}/materials', 'MaterialsController@userIndex');

        });
    });

});
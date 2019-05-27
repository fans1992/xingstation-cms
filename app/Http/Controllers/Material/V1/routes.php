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

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\Customer'], function ($api) {

            //素材列表
            $api->get('materials', ['middleware' => ['permission:cms_material.material.read'], 'uses' => 'MaterialsController@index']);

            //上传素材
            $api->post('materials', ['middleware' => ['permission:cms_material.material.create'], 'uses' => 'MaterialsController@store']);

            //查看素材
            $api->get('materials/{material}', ['middleware' => ['permission:cms_material.material.read'], 'uses' => 'MaterialsController@show']);

            //修改素材
            $api->put('materials/{material}', ['middleware' => ['permission:cms_material.material.update'], 'uses' => 'MaterialsController@update']);

            //删除素材
            $api->delete('materials/{material}', ['middleware' => ['permission:cms_material.material.delete'], 'uses' => 'MaterialsController@destroy']);

            //我的素材
            $api->get('users/{user}/materials', ['middleware' => ['permission:cms_material.material.read'], 'uses' => 'MaterialsController@userIndex']);
        });


    });

});
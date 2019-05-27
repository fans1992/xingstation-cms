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

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\Customer'], function ($api) {

            //作品列表
            $api->get('works', ['middleware' => ['permission:cms_work.work.read'], 'uses' => 'WorksController@index']);

            //发布作品
            $api->post('works', ['middleware' => ['permission:cms_work.work.create'], 'uses' => 'WorksController@store']);

            //查看作品
            $api->get('works/{work}', ['middleware' => ['permission:cms_work.work.read'], 'uses' => 'WorksController@show']);

            //修改作品
            $api->put('works/{work}', ['middleware' => ['permission:cms_work.work.update'], 'uses' => 'WorksController@update']);

            //删除作品
            $api->delete('works/{work}', ['middleware' => ['permission:cms_work.work.delete'], 'uses' => 'WorksController@destroy']);

            //模板列表
            $api->get('templets/works', ['middleware' => ['permission:cms_work.work.read'], 'uses' => 'WorksController@templetIndex']);
        });

        $api->get('/works/preview/{work}', 'WorksController@preview');

    });

});
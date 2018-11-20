<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Admin\Store\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
    
        //验光点列表
        $api->get('opticalStores', 'OpticalStoresController@index');

    });

});
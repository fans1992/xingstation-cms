<?php
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Admin\Common\V1\Api',
    'middleware' => ['serializer:array', 'bindings'] //api返回数据切换. Fractal 组件默认提供  DataArraySerializer ArraySerializer
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',//频率限制中间件
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        $api->post('captcha', 'CaptchaController@store');// 图片验证码

        $api->group(['middleware' => "api.auth", 'model' => 'App\Models\User'], function ($api) {

            //消息通知
            $api->get('customer/notifications', 'NotificationsController@index');
            $api->get('customer/notifications/stats', 'NotificationsController@stats');
            $api->patch('customer/read/notifications', 'NotificationsController@read');
            $api->get('customer/activities', 'ActivityLogController@index');

            //数据报表
            $api->get('chart_data/orders', 'ChartDataController@index'); //订单列表
            $api->post('chart_data', 'ChartDataController@chart');//图表

        });
    });

});
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-6-14
 * Time: 下午4:56
 */

namespace app\Listeners;

use Illuminate\Events\Dispatcher;
use Log;

class CustomerEventSubscriber
{

    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event)
    {
        $user = $event->user;
        Log::info('on_user_login', ['user' => $user]);
    }

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event)
    {

    }

    /**
     * @param $event
     */
    public function onFailed($event)
    {
    }

    /**
     * 为订阅者注册监听器。
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Failed',
            'App\Listeners\UserEventSubscriber@onFailed'
        );

        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}
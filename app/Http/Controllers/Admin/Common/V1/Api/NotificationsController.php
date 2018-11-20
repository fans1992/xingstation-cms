<?php

namespace App\Http\Controllers\Admin\Common\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Transformer\NotificationTransformer;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = $this->user->notifications()->paginate(10);

        return $this->response->paginator($notifications, new NotificationTransformer());
    }

    public function stats()
    {
        return $this->response->array([
            'unread_count' => $this->user()->notification_count,
        ]);
    }

    public function read()
    {
        $this->user()->markAsRead();

        return $this->response->noContent();
    }
}

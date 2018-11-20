<?php

namespace App\Http\Controllers\Admin\Common\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Transformer\ActivityLogTransformer;
use App\Http\Controllers\Admin\Common\V1\Request\ActivityLogRequest;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index(ActivityLogRequest $request, Activity $activity)
    {

        $query = $activity->query();
        $activityLogs = $query->where('causer_type', 'App\Models\Customer')->orderBy('id', 'desc')->paginate(10);

        return $this->response->paginator($activityLogs, new ActivityLogTransformer());
    }
}

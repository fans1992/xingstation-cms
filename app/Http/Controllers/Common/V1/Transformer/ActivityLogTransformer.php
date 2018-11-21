<?php

namespace App\Http\Controllers\Admin\Common\V1\Transformer;

use App\Http\Controllers\Admin\Customer\V1\Transformer\CustomerTransformer;
use League\Fractal\TransformerAbstract;
use Spatie\Activitylog\Models\Activity;

class ActivityLogTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['causer'];

    public function transform(Activity $activity)
    {
        return [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'description' => $activity->description,
            'properties' => $activity->properties,
            'created_at' => $activity->created_at->toDateTimeString(),
            'updated_at' => $activity->updated_at->toDateTimeString(),
        ];
    }

    public function includeCauser(Activity $activity)
    {
        return $this->item($activity->causer, new CustomerTransformer());
    }
}
<?php

namespace App\Http\Traits;

use Spatie\Activitylog\Models\Activity;

trait AuditTrait
{
    public function getActivities()
    {
        return Activity::query();
    }
    public function getActivity($activity_id)
    {
        return Activity::find($activity_id);
    }

}

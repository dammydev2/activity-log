<?php

namespace App\Services;

use App\ActivityLog;
use Jenssegers\Agent\Agent;

class ActivityService
{
    protected $activityLog;
    public function __construct(
        ActivityLog $activityLog
    ) {
        $this->activityLog = $activityLog;
    }

    public function enterActivity($user_activity,$email)
    {
        $agent = new Agent();
        $platform = $agent->platform();
        // Ubuntu, Windows, OS X, ...
        $browser = $agent->browser();
        // Chrome, IE, Safari, Firefox, ...
        $this->activityLog->create([
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'ip_address' => \Request::ip(),
            'user_id' => 1,
            'user_email' => $email,
            'user_activity' => $user_activity
        ]);
    }
}

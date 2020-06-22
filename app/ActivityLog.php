<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'device',
        'platform',
        'browser',
        'ip_address',
        'user_id',
        'user_email',
        'user_activity'
    ];
}

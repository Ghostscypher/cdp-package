<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'cdp_logs';

    protected $fillable = [
        'service_uuid', 'event_name', 'message', 
        'type', 'level',
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_uuid', 'service_uuid');
    }

}

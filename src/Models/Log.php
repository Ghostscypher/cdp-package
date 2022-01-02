<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'cdp_logs';

    protected $fillable = [
        'event_name', 'message', 
        'type', 'level',
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
}

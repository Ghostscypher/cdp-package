<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'cdp_logs';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
}

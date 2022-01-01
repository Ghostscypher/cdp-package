<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'cdp_services';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
}

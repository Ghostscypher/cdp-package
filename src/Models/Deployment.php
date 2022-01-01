<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;

    protected $table = 'cdp_deployments';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
}

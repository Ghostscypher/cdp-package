<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThisService extends Model
{
    use HasFactory;

    protected $table = 'cdp_this_service';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
    
}

<?php

namespace Ghostscypher\CDP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $table = 'cdp_credentials';

    protected $fillable = [
        'service_uuid', 'key', 'secret'
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
    
}

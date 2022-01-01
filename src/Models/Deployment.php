<?php

namespace Ghostscypher\CDP\Models;

use Ghostscypher\CDP\Traits\HasCredentials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory, HasCredentials;

    protected $table = 'cdp_deployments';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function service()
    {
        return $this->morphTo();
    }
}

<?php

namespace Ghostscypher\CDP\Models;

use Ghostscypher\CDP\Traits\HasCredentials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory, HasCredentials;

    protected $table = 'cdp_deployments';

    protected $fillable = [
        'service_id', 'service_uuid', 'url', 'product_name',
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function service()
    {
        return $this->morphTo();
    }
}

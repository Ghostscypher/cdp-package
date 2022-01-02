<?php

namespace Ghostscypher\CDP\Models;

use Ghostscypher\CDP\Traits\HasCredentials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasCredentials;

    protected $table = 'cdp_services';

    protected $fillable = [
        'service_uuid', 'product_name',
        'deployment_url', 'description',
        'type', 'status',
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function service()
    {
        return $this->morphTo();
    }
}

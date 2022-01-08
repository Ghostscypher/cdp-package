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

    protected $hidden = [
        'key', 'secret'
    ];

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function service(){
        return $this->morphTo('service');
    }
    
    public function getEncodedCredentialAttribute(){
        return base64_encode("{$this->key}:{$this->secret}");
    }

    public function getEncodedBearerCredentialAttribute(){
        return base64_encode("Bearer " . $this->getEncodedCredentialAttribute());
    }

}

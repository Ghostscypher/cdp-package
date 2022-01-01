<?php

namespace Ghostscypher\CDP\Traits;

use Ghostscypher\CDP\Models\Credential;

trait HasCredentials
{
    public function credential()
    {
        return $this->morphOne(Credential::class, 'service');
    }
}

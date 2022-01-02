<?php

namespace Ghostscypher\CDP\Facades;

use Illuminate\Support\Facades\Facade;

class CDP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CDP';
    }
}
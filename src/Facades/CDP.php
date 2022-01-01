<?php

namespace JohnDoe\BlogPackage\Facades;

use Illuminate\Support\Facades\Facade;

class CDP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CDP';
    }
}
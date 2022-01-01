<?php

namespace Ghostscypher\CDP\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CDPActionErrorEvent
{
    use Dispatchable;
    
    public function __construct() 
    {
    }
}
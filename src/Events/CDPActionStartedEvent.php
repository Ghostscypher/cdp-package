<?php

namespace Ghostscypher\CDP\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CDPActionStartedEvent
{
    Use Dispatchable;
    
    public function __construct() 
    {
    }
}
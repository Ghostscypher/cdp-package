<?php

namespace Ghostscypher\CDP\Actions\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CDPActionStartingEvent
{
    use Dispatchable;
    
    public function __construct() 
    {
    }
}
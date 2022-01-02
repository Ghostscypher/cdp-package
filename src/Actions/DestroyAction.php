<?php

namespace Ghostscypher\CDP\Actions;

use Ghostscypher\CDP\Contracts\CDPActionContract;

class DestroyAction implements CDPActionContract
{
    public function execute(): void
    {
        
    }

    /**
     * @return array Commands that will be run for this action
     */
    public function commands(): array
    {
        return [];
    }

    
    /**
     * Indicates if at this action the app is authorized to continue
     */
    public function authorize(): bool
    {
        return false;
    }
}
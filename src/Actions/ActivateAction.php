<?php

namespace Ghostscypher\CDP\Actions;

use Ghostscypher\CDP\Contracts\CDPActionContract;

class ActivateAction implements CDPActionContract
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
        return true;
    }

    /**
     * Array of rules to be used for validation
     */
    public function rules(): array
    {
        return [];
    }
}
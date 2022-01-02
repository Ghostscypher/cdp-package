<?php

namespace Ghostscypher\CDP\Contracts;

interface CDPActionContract 
{
    /**
     * @return array Commands that will be run for this action
     */
    public function commands(): array;

    /**
     * Will be called for each action
     */
    public function execute(): void;

    /**
     * Indicates if at this action the app is authorized to continue
     */
    public function authorize(): bool;

    /**
     * Array of rules to be used for validation
     */
    public function rules(): array;

}
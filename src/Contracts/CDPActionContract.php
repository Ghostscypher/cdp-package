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

}
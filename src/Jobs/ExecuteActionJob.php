<?php

namespace Ghostscypher\CDP\Jobs;

use Closure;
use Ghostscypher\CDP\Contracts\CDPActionContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\SerializableClosure\SerializableClosure;

class ExecuteActionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $action;
    private $data;

    /**
     * Create a new job instance.
     *
     * @param CDPActionContract $action
     * @param null $data
     */
    public function __construct(CDPActionContract $action, $data = null)
    {
        $this->action = $action;
        $this->data = $data ?? [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Call the function passing the data to it
        $this->action->execute($this->data);
    }
}

<?php

namespace Ghostscypher\CDP\Jobs;

use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\SerializableClosure\SerializableClosure;

class UsesClosureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $closure;
    private $data;

    /**
     * Create a new job instance.
     *
     * @param Closure $closure
     * @param null $data
     */
    public function __construct(SerializableClosure $closure, $data = null)
    {
        $this->closure = $closure;
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
        $this->closure->call($this);
    }
}

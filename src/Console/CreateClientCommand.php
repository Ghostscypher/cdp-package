<?php

namespace Ghostscypher\CDP\Console;

use Illuminate\Console\Command;

class CreateClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp-client:create
                            {--client-name= : The name of the client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a CDP client together with credentials';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}

<?php

namespace Ghostscypher\CDP\Console;

use Illuminate\Console\Command;

class RegisterClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp-client:register
                            {--client_name= : The name of the client}
                            {--client_key= : The client key}
                            {--client_secret : The client secret}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a CDP client together with credentials';

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

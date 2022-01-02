<?php

namespace Ghostscypher\CDP\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install CDP package';

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
        $this->line('Publishing migrations...');
        $params = [
            '--provider' => "Ghostscypher\CDP\CDPServiceProvider",
            '--tag' => "cdp-migrations"
        ];
        $this->publish($params);
        $this->info('Published migrations');

        // -------------------------------- //

        // Config
        $this->line('Publishing config...');
        $params = [
            '--tag' => "cdp-config"
        ];
        $this->publish($params);
        $this->info('Published config');

        return 0;
    }

    protected function publish($params)
    {
        Artisan::call('vendor:publish', $params);
    }

}

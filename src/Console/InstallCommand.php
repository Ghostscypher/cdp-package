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
        $this->info('Publishing migrations...');

        $params = [
            '--provider' => "Ghostscypher\CDP\CDPServiceProvider",
            '--tag' => "cdp-migrations"
        ];

        Artisan::call('vendor:publish', $params);

        $this->info('Published migrations');

        // Config
        $this->info('Publishing config...');

        $params = [
            '--provider' => "Ghostscypher\CDP\CDPServiceProvider",
            '--tag' => "cdp-config"
        ];

        Artisan::call('vendor:publish', $params);

        $this->info('Published config');

        if($this->wantToMigrate()){
            Artisan::call("migrate --path=" . database_path('migrations/cdp'));

            echo Artisan::output();
        }

        return 0;
    }

    protected function wantToMigrate()
    {
        return $this->confirm("Do you want to run the migrations?", true);
    }
}

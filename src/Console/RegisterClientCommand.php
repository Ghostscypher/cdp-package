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
                            {--client_name= : The name/uuid of the client}
                            {--client_key= : The client key}
                            {--client_secret : The client secret}
                            {--product_name= : The name of the product e.g. Afri link}
                            {--deployment_url= : The URL called when this service is being deployed}';

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
        if(!$this->hasOption('client_name'))
        {
            $this->addOption('client_name', default: $this->askForClientName());
        }

        if(!$this->hasOption('client_key'))
        {
            $this->addOption('client_key', default: $this->askForClientSecret());
        }

        if(!$this->hasOption('client_secret'))
        {
            $this->addOption('client_secret', default: $this->askForClientSecret());
        }

        if(!$this->hasOption('product_name'))
        {
            $this->addOption('product_name', default: $this->askForProductName());
        }

        if(!$this->hasOption('deployment_url'))
        {
            $this->addOption('deployment_url', default: $this->askForDeploymentUrl());
        }
        
        return 0;
    }

    protected function askForClientName(){
        return $this->ask('Input client name: ');
    }

    protected function askForClientKey(){
        return $this->ask('Input client key: ');
    }

    protected function askForClientSecret(){
        return $this->ask('Input client secret: ');
    }

    protected function askForProductName(){
        return $this->ask('Input product name: ');
    }

    protected function askForDeploymentUrl(){
        return $this->ask('Input deployment url: ');
    }

}

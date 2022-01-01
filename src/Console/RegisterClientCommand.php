<?php

namespace Ghostscypher\CDP\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

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
        if(!$this->option('client_name'))
        {
            $this->input->setOption('client_name', $this->askForClientName());
        }

        if(!$this->option('client_key'))
        {
            $this->input->setOption('client_key', $this->askForClientSecret());
        }

        if(!$this->option('client_secret'))
        {
            $this->input->setOption('client_secret', $this->askForClientSecret());
        }

        if(!$this->option('product_name'))
        {
            $this->input->setOption('product_name', $this->askForProductName());
        }

        if(!$this->option('deployment_url'))
        {
            $this->input->setOption('deployment_url', $this->askForDeploymentUrl());
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

<?php

namespace Ghostscypher\CDP\Console;

use Ghostscypher\CDP\Facades\CDP;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RegisterClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp-client:register
                            {--client_uuid= : The uuid of the client}
                            {--client_key= : The client key}
                            {--client_secret : The client secret}
                            {--product_name= : The name of the product e.g. Afri link}
                            {--deployment_url= : The URL called when this service is being deployed}
                            {--base64_all= : Base 64 of all the data generated}';

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
        $data = null;

        if($this->option('base64_all')){
            $data = json_decode(base64_decode($this->option('base64_all')));
        }

        if(!$this->option('client_uuid'))
        {
            $this->input->setOption('client_uuid', $data->service_uuid ?? $this->askForClientUUID());
        }

        if(!$this->option('client_key'))
        {
            $this->input->setOption('client_key', $data->credential->key ?? $this->askForClientKey());
        }

        if(!$this->option('client_secret'))
        {
            $this->input->setOption('client_secret', $data->credential->secret ?? $this->askForClientSecret());
        }

        if(!$this->option('product_name'))
        {
            $this->input->setOption('product_name', $data->product_name ?? $this->askForProductName());
        }

        if(!$this->option('deployment_url'))
        {
            $this->input->setOption('deployment_url', $data->deployment_url ?? $this->askForDeploymentUrl());
        }

        DB::beginTransaction();

        try{
            
            $service = CDP::serviceModel()->create([
                'service_uuid' => $this->option('client_uuid'),
                'product_name' => $this->option('product_name'),
                'deployment_url' => $this->option('deployment_url'),
                'type' => 'main',
                'status' => 'active',
            ]);

            $service->credential()->create([
                'key' => $this->option('client_key'), 
                'secret' => $this->option('client_secret'),
            ]);

            DB::commit();

            $this->line('Successfully registered client');
        } catch(\Throwable $th){
            DB::rollBack();

            throw $th;
        }

        return 0;
    }

    protected function askForClientUUID(){
        return $this->ask('Input client UUID');
    }

    protected function askForClientKey(){
        return $this->ask('Input client key');
    }

    protected function askForClientSecret(){
        return $this->ask('Input client secret');
    }

    protected function askForProductName(){
        return $this->ask('Input product name');
    }

    protected function askForDeploymentUrl(){
        return $this->ask('Input deployment url');
    }

}

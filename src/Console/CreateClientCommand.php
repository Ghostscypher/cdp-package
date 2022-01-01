<?php

namespace Ghostscypher\CDP\Console;

use Ghostscypher\CDP\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CreateClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp-client:create
                            {--product_name= : The name of the product e.g. Afri link}
                            {--deployment_url= : The URL called when this service is being deployed}';

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
        if(!$this->option('product_name'))
        {
            $this->input->setOption('product_name', $this->askForProductName());
        }

        if(!$this->option('deployment_url'))
        {
            $this->input->setOption('deployment_url', $this->askForDeploymentUrl());
        }
     
        DB::beginTransaction();

        try{
            $service = Service::create([
                'service_uuid' => Str::uuid(),
                'product_name' => $this->option('product_name'),
                'deployment_url' => $this->option('deployment_url'),
            ]);

            $service->credential()->create([
                'key' => Str::random(32), 
                'secret' => Str::random(16),
            ]);

            DB::commit();

            // Display the result
            $this->line(sprintf("Service UUID: %s", $service->service_uuid));
            $this->line('');

            $this->info(sprintf("Product Name: %s", $service->product_name));
            $this->line('');

            $this->info(sprintf("Deployment Url: %s", $service->deployment_url));
            $this->line('');

            $this->info(sprintf("Client Key: %s", $service->credential->key));
            $this->line('');

            $this->info(sprintf("Client Secret: %s", $service->credential->secret));
            $this->line('');

            // JSON array
            $this->info(sprintf("Base64 all data: %s", base64_encode($service->toJSON())));
            $this->line('');
            
        } catch(\Throwable $th){
            DB::rollBack();

            throw $th;
        }

        return 0;
    }

    protected function askForProductName(){
        return $this->ask('Input product name: ');
    }

    protected function askForDeploymentUrl(){
        return $this->ask('Input deployment url: ');
    }
}

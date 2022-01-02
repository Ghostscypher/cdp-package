<?php

namespace Ghostscypher\CDP\Console;

use Ghostscypher\CDP\Facades\CDP;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp-client:drop
                            {--client_uuid= : The uuid of the client}';

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
        if(!$this->option('client_uuid'))
        {
            $this->input->setOption('client_uuid', $this->askForClientUUID());
        }

        if(!$this->confirm("Are you sure you want to delete client: " . $this->option('client_uuid')))
        {
            return 0;
        }

        DB::beginTransaction();

        try{
            
            $service = CDP::serviceModel()->where([
                'service_uuid' => $this->option('client_uuid'),
            ])->firstOrFail();

            $service->credential()->delete();
            $service->delete();

            DB::commit();

            $this->line('Successfully deleted client');
        } catch(\Throwable $th){
            DB::rollBack();

            throw $th;
        }

        return 0;
    }

    protected function askForClientUUID(){
        return $this->ask('Input client UUID');
    }

}

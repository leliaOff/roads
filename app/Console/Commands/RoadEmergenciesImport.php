<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoadEmergencies;
class RoadEmergenciesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roademer:import {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $data = file_get_contents(base_path('import').DIRECTORY_SEPARATOR.$this->argument('filename'));
        if($data === false) {
            $this->error("Error: Cannot read file {$this->argument('filename')}");
        }
        $json = json_decode($data,true);
        if(empty($json)){
            $this->error("Error: Cannot decode data in {$this->argument('filename')}");
        }

        foreach($json as $work){
            $this->info("Import emer");
            $roadWork = new RoadEmergencies();
            $roadWork->reg_code = $work['reg_code'];
            $roadWork->reg_name = $work['reg_name'];
            $roadWork->kind = $work['emergency_kind'];
            $roadWork->description = $work['emergency_description'];
            $roadWork->date = date('Y-m-d',strtotime($work['emergency_date']));
            $roadWork->lat = $work['latitude'];
            $roadWork->lon = $work['longitude'];
            $roadWork->save();
        }
        $this->info('Import finished');
    }
}

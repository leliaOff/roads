<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoadAccidents;
class RoadAccidentsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roadacc:import {filename}';

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
            $this->info("Import accident at {$work['road_name']}");
            $roadWork = new RoadAccidents();
            $roadWork->crash_type = $work['crash_type_name'];
            $roadWork->crash_reason = $work['crash_reason'];
            $roadWork->region_code = $work['reg_code'];
            $roadWork->region_name = $work['reg_name'];
            $roadWork->road_type = $work['road_type'];
            $roadWork->road_code = $work['road_code'];
            $roadWork->road_name = $work['road_name'];
            $roadWork->crash_date = date('Y-m-d',strtotime($work['crash_date']));
            $roadWork->lat = empty($work['latitude']) ? '65.970112' : $work['latitude'];
            $roadWork->lon = empty($work['longitude']) ? '78.104234' : $work['longitude'];
            $roadWork->save();
        }
        $this->info('Import finished');
    }
}

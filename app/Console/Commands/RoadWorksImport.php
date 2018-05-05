<?php

namespace App\Console\Commands;

use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;
use Illuminate\Console\Command;
use App\Models\RoadWorks;
class RoadWorksImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roadworks:import {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads Road Works into DB';

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

        $defaultStartPoint = new Point(65.970112,78.104234);
        $defaultEndPoint = new Point(65.973731,78.08459);
        foreach($json as $work){
            $this->info("Import road {$work['road_name']}");
            $roadWork = new RoadWorks();
            $roadWork->reason = $work['reason'];
            $roadWork->trouble_type = $work['trouble_type'];
            $roadWork->repair_kind = $work['repair_kind'];
            $roadWork->reason = $work['reason'];
            $roadWork->region_code = $work['reg_code'];
            $roadWork->region_name = $work['reg_name'];
            $roadWork->road_type = $work['road_type'];
            $roadWork->road_code = $work['road_code'];
            $roadWork->road_name = $work['road_name'];
            $roadWork->work_started_at = date('Y-m-d',strtotime($work['date_start_plan']));
            $roadWork->work_finished_at = date('Y-m-d',strtotime($work['date_end_plan']));
            $roadWork->start_lat = empty($work['start_latitude']) ? '65.970112' : $work['start_latitude'];
            $roadWork->start_lon = empty($work['start_longitude']) ? '78.104234' : $work['start_longitude'];
            $roadWork->end_lat = empty($work['end_latitude']) ? '65.970112' : $work['end_latitude'];
            $roadWork->end_lon = empty($work['end_longitude']) ? '78.104234' : $work['end_longitude'];
            $roadWork->save();
        }
        $this->info('Import finished');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadWorks extends Model
{
    protected $table = 'road_works';
    protected $fillable = [
        'id','performer','reason','trouble_type','repair_kind','road_type','road_name','road_code','region_code','region_name','work_started_at','work_finished_at','work_actually_started_at','work_actually_finished_at','start_coordinates','end_coordinates','created_at','updated_at'
    ];
}

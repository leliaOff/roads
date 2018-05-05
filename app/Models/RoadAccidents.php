<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadAccidents extends Model
{
    protected $table = 'road_accidents';
    protected $fillable = [
        'id','crash_type','crash_reason','crash_date','road_type','road_name','road_code','region_code','region_name','lat','lon','created_at','updated_at'
    ];
}

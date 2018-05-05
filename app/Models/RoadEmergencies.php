<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadEmergencies extends Model
{
    protected $table = 'road_emergencies';
    protected $fillable = [
        'id','reg_code','reg_name','data','kind','description','lat','lon'
    ];
}

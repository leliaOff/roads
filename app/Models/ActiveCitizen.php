<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveCitizen extends Model
{
    protected $table = 'active_citizen';
    protected $fillable = [
        'id','type','description','lat','lon','created_at','updated_at'
    ];
}

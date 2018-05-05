<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GibddOnline extends Model
{
    protected $table = 'gibdd_online';
    protected $fillable = [
        'id','description','transport_number','offence_registered_at','lat','lon','files'
    ];
}

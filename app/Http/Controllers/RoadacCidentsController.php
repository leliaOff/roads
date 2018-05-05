<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoadacCidentsController extends Controller
{
    private $date = [ 
        { 
        "repair_kind": "Ремонт", 
        "date_start": "", 
        "date_end": "", 
        "date_start_plan": "20180301", 
        "date_end_plan": "20180301", 
        "start_latitude": "", 
        "start_longitude": "", 
        "end_latitude": "", 
        "end_longitude": "", 
        "reason": "Не определена", 
        "trouble_type": "Не определен" 
        } 
    ]

    public function getData() {
        dd($this->date);
        return $this->date;
    }
}

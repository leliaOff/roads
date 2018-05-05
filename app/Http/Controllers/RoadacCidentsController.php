<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoadacCidentsController extends Controller
{

    public function getData() {
        return $this->mockeData();
    }

    private function mockeData() {
        return [(object)[ 
            "repair_kind"=> "Ремонт", 
            "date_start"=> "", 
            "date_end"=> "", 
            "date_start_plan"=> "20180301", 
            "date_end_plan"=> "20180301", 
            "start_latitude": "65.970112", 
            "start_longitude": "78.104234", 
            "finish_latitude": "65.973731", 
            "finish_longitude": "78.08459",
            "reason"=> "Не определена", 
            "trouble_type"=> "Не определен" 
        ],
        (object)[ 
            "repair_kind"=> "Ремонт", 
            "date_start"=> "", 
            "date_end"=> "", 
            "date_start_plan"=> "20180301", 
            "date_end_plan"=> "20180301", 
            "start_latitude": "65.970312", 
            "start_longitude": "78.104534", 
            "finish_latitude": "65.973731", 
            "finish_longitude": "78.08159",
            "reason"=> "Не определена", 
            "trouble_type"=> "Не определен" 
        ]];
    }
}

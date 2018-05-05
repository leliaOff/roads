<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoadAccidents;
use App\Models\RoadWorks;

class RoadacCidentsController extends Controller
{

    public function getRoadWorks() {
        
        $data = RoadWorks::orderBy('id')->limit(5)->get();
        $array = [];
        for ($i = 0; $i < count($data); $i++) {
            $array[] = [
                'id' => $data[$i]['id'],
                'coordinates' => $this->coordinates($data[$i]),
                'type' => 'MultiPolygon',
                'name' => $data[$i]['repair_kind'],
                'layer' => 'layer3'
            ];
        }

        return $array;

    }

    private function coordinates($data) {
        $array = [];
        $array[] = [$data['start_lon'] - 0.0001, $data['start_lat'] - 0.0001];
        $array[] = [$data['start_lon'] + 0.0001, $data['start_lat'] + 0.0001];
        $array[] = [$data['end_lon'] + 0.0001, $data['end_lat'] + 0.0001];
        $array[] = [$data['end_lon'] - 0.0001, $data['end_lat'] - 0.0001];
        return $array;
    }

    public function getRoadAccidents() {
        $data = RoadAccidents::orderBy('id')->limit(5)->get();
        $array = [];
        for ($i = 0; $i < count($data); $i++) {
            $array[] = [
                'id' => $data[$i]['id'],
                'coordinates' => [(float)$data[$i]['lon'],  (float)$data[$i]['lat']],
                'type' => 'point',
                'name' => $data[$i]['crash_type'],
                'layer' => 'layer1'
            ];
        }
        return $array;
    }

}

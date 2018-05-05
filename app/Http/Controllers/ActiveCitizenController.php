<?php

namespace App\Http\Controllers;
use App\Models\ActiveCitizen;
use Illuminate\Http\Request;

class ActiveCitizenController extends Controller
{
    public function create(Request $request){
        try{
            $citizen = new ActiveCitizen();
            $citizen->type = $request->type;
            $citizen->description = $request->description;
            $citizen->lat = $request->lat;
            $citizen->lon = $request->lon;
            $citizen->save();
        } catch (\Exception $ex){
            return response('',500);
        }
        return $citizen;
    }

    public function list(){
        return ActiveCitizen::all();
    }
}

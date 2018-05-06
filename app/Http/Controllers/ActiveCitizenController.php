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
            $citizen->lat = $request->coordinates[0][0];
            $citizen->lon = $request->coordinates[0][1];
            $citizen->likes = 0;            
            $citizen->files = json_encode($request->files_uploaded);
            $citizen->save();
        } catch (\Exception $ex){
            return response($ex->getMessage(),500);
        }
        return $citizen;
    }

    public function list() {
        dd(ActiveCitizen::all()->toArray());
        return ActiveCitizen::all();
    }

    public function like(Request $request){
        try{
            $entry = ActiveCitizen::where('id',$request->id)->firstOrFail();
        } catch(\Exception $ex){
            return response($ex->getMessage(),500);
        }
        $entry->likes++;
        try{
            $entry->save();
        } catch(\Exception $ex){
            return response($ex->getMessage(),500);
        }
        return $entry;
    }
}

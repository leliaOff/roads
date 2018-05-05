<?php

namespace App\Http\Controllers;
use App\Models\GibddOnline;
use Illuminate\Http\Request;

class GidbbOnlineController extends Controller
{
    public function create(Request $request){
        try{
            $claim = new GibddOnline();
            $claim->description = $request->description;
            $claim->transport_number = $request->transport_number;
            $claim->offence_registered_at = $request->offence_registered_at;
            $claim->lat = $request->lat;
            $claim->lon = $request->lon;
            $claim->user_id = 1;
            $claim->files = $request->files_offence;
            $claim->save();
        } catch(\Exception $ex){
            return response($ex->getMessage(),500);
        }
        return $claim;
    }

    public function list(Request $request){
        return GibddOnline::where('user_id',$request->user_id)->get();
    }
}

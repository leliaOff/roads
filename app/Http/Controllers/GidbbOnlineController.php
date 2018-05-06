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
            $claim->lat = $request->coordinates[0][0];
            $claim->lon = $request->coordinates[0][1];
            $claim->user_id = 1;
            $files = $request->files_offence;
            if(empty($request->files_offence)){
                $files = array();
            }
            $claim->files = json_encode($files);
            $claim->save();
        } catch(\Exception $ex){
            return response($ex->getMessage(),500);
        }
        return $claim;
    }

    public function list(Request $request){
        return GibddOnline::where('user_id', $request->user_id)->get();
    }
}

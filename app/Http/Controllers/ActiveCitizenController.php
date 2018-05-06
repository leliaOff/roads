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
        $data = ActiveCitizen::orderBy('id')->get();
        $array = [];
        for ($i = 0; $i < count($data); $i++) {
            $array[] = [
                'id' => $data[$i]['id'],
                'coordinates' => [(float)$data[$i]['lat'], (float)$data[$i]['lon']],
                'type' => 'point',
                'description' => $this->type($data[$i]['type']),
                'layer' => 'layer4',
                'data' => $this->data($data[$i]->toArray())
            ];
        }
        return $array;
    }

    private function data($data) {

        return [
            'description'=>$data['description'],
            'type'=>$this->type($data['type']),
            'likes'=>$data['likes'],
            'id'=>$data['id']
        ];

    }

    private function type($i) {
        
        switch ($i) {
            case '1':
                return "яма на дороге";
                break;
            case '2':
                return "нет тротуара";
                break;
            case '3':
                return "нет разметки на дороге";
                break;
            case '4':
                return "отсутствует освещение";
                break;
            case '5':
                return "проход по тротуару невозможен";
                break;
        }
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

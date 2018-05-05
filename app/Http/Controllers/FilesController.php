<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DateTime;

class FilesController extends Controller
{

	public function __construct()
	{

    }

    public function uploads(Request $request)
    {
        $result = [];
        
        foreach($request['files'] as $file) {

            $file 		= $file->store('public/files');
            $filename 	= Storage::url($file);
            $result[]   = $filename;
        }

        return $result;
	}

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller{
    public function sendResponse($response,$status="Success",$code=200){
        return response()->json(['data'=>$response,'status'=>$status],$code);
    }
}

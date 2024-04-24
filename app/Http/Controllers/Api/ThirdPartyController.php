<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Http;

class ThirdPartyController extends BaseController
{
    public function index(){
        $response=Http::get('https://hawyatshipping.com/api/get-ports/Sea-533');
        return $this->sendResponse($response->json());
    }
}

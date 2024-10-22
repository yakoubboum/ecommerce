<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index(){
        // Redis::set('user', 'yaaqoub');

        $value = Redis::get('user');
        return $value;
    }
}

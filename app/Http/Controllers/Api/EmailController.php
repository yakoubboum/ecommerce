<?php

namespace App\Http\Controllers\Api;

use App\Mail\emailMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends BaseController
{
    public function send(){
        Mail::to(Auth::user()->email)->send(new emailMailable());
        return $this->sendResponse("Email Sent");
    }
}

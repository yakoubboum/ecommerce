<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Stripe;
use Stripe\Stripe as StripeStripe;

class StripePaymentController extends Controller
{
    public function stripe($price)
    {
        return view('Dashboard.User.stripe',\compact('price'));
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            'amount' => 100*100,
            'currency'=>"usd",
            'source'=> $request->stripeToken,
            'description' =>'Test payment from yaaqoub'
        ]);
        session()->flash('success','Payment has been successfully');
        // Session::flash('success','Payment has been successfully');
        return back();
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaymentController extends Controller
{

    public function payment($id)
    {

        $product = Product::findOrfail($id);
        
        $data = [];

        $data['items'] = [
            [
                'name' => $product->name,
                'price' => $product->price - ($product->discount * $product->price) / 100,
                'desc' => 'desc',
                'qty' => 1,
                
            ],
    
        ];
        $data['invoice_id'] = 1;
        $data['invoice_description'] = 'invoice_description';
        $data['return_url'] = 'http://127.0.0.1:8000/en/dashboard/user/payment/success/'.$product->id;
        $data['cancel_url'] = 'http://127.0.0.1:8000/en/dashboard/user/payment/cancel';


        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
        $paypal = new ExpressCheckout();
        $response = $paypal->setExpressCheckout($data, true);

        return \redirect($response['paypal_link']);
    }

    public function success(Request $request,$id)
    {
        $provider = new ExpressCheckout();
        $response = $provider->getExpressCheckoutDetails($request->token);

       
        $product = Product::findOrfail($id);
        if (strtoupper($response['ACK']) === 'SUCCESS') {
            Order::create([
                'user_id' => auth()->user()->id, // Assuming user is logged in
                'product_id' => $product->id,
                'quantity' => 1, // Modify if quantity can vary
            ]);
            return response()->json('paid success');
        }

        return response()->json('paid failed ');
    }

    public function cancel()
    {

        return redirect('/')->with('message', 'Payment cancelled.');
    }
}

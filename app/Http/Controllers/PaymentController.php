<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {

        // $validator = $this->validate($request, [
        //     'amount' => 'required|numeric|min:0.01', // Ensure a valid amount
        //     'description' => 'required|string',
        // ]);
        $data = [];

        $data['items'] = [
            [
                'name' => 'gg',
                'price' => '100',
                'desc' => 'desc',
                'qty' => 2,
            ],
            [
                'name' => 'gg2',
                'price' => '100',
                'desc' => 'desc',
                'qty' => 2,
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = 'invoice_description';
        $data['return_url'] = 'http://127.0.0.1:8000/en/dashboard/user/product/2';
        $data['cancel_url'] = 'http://127.0.0.1:8000/en/dashboard/user/product/2';


        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;






        // $data = [
        //     'intent' => 'sale',
        //     'invoice_id' => uniqid(), // Generate a unique invoice ID
        //     'invoice_description' => 'invoice_description',
        //     'total' => '50',
        //     'currency' => config('paypal.currency'),
        //     'return_url' => route('payment.success'), // Route for successful payment
        //     'cancel_url' => route('payment.cancel'), // Route for cancellation
        // ];

        $paypal = new ExpressCheckout();


        $response = $paypal->setExpressCheckout($data, true);

        
        return \redirect($response['paypal_link']);
    }

    public function success(Request $request)
    {
        $provider = new ExpressCheckout();
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (\in_array(\strtoupper($response['ACK']), ['SUCCEES', 'SUCCEESWITHWARNING'])) {
            return response()->json('paid success');
        }

        return response()->json('paid failed');










        // $paypal = new ExpressCheckout(config('paypal.credentials')[config('paypal.mode')]);

        // try {
        //     $token = $request->get('token');
        //     $payerId = $request->get('PayerID');

        //     $payment = $paypal->getExpressCheckoutDetails($token);
        //     $confirmation = $paypal->doExpressCheckoutPayment($payment['id'], $payerId, config('paypal.currency'), $payment['total']);

        //     // Process successful payment (e.g., record order, send confirmation email)
        //     return \back();
        // } catch (\Exception $e) {
        //     return back()->withErrors(['message' => 'Error processing payment: ' . $e->getMessage()]);
        // }
    }

    public function cancel()
    {

        return redirect('/')->with('message', 'Payment cancelled.');
    }
}

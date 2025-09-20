<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(): View
    {
        return view('stripe');
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request): RedirectResponse
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      
        Stripe\Charge::create ([
                "amount" => $request->AMOUNT,
                "currency" => "eur",
                "source" => $request->stripeToken,
                "description" => $request->DESCRIPTION 
        ]);
                
        return back()
                ->with('success', 'Payment successful!');
    }
        /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCheckout(Request $request)
    {
        require '../vendor/autoload.php';

        $stripe = new \Stripe\StripeClient([
            "api_key" => 'sk_test_51QzlmjDxX0TtHUyvb09OIVunJuRs7y3rXhQRL7MMp1nFoZNdte5vj20lSzIcpX3HDEKi5nvvxfid5GY0Lp2bHiCR00miD9LCM7'
        ]);

        $orderNumber = explode("_", $request->orderNumber)[0];
        $price = explode('_', $request->orderNumber)[1];
        $userId = intval(explode('_', $request->orderNumber)[2]) > 0 ? explode('_', $request->orderNumber)[2] : 0;

        $checkout_session = $stripe->checkout->sessions->create([
            'client_reference_id' => $orderNumber,
            'line_items' => [[
                'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Shipment '.$orderNumber,
                ],
                'unit_amount' => $price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'ui_mode' => 'embedded',
            'return_url' => 'http://localhost:8080/#/checkout-return/{CHECKOUT_SESSION_ID}/'.$orderNumber.'/'.$userId,
        ]);

        echo json_encode(array('checkout_session' => $checkout_session));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AppHelper;

class StripeController extends Controller
{
    public function createPaymentSheet(Request $requestData) {

        $stripe = new \Stripe\StripeClient(
            'sk_test_51MKA4XIEqQjBiuwuUs3p4aOS08zhro8C5TPCuR2r0IR7MFYrF0CWsbWwWVE460TiIFeNaFX3ZtNnpEOlXSkYo53j00BsDThFl2'
        );

        $params = [
            [
                "email" => $requestData['emailAddress'],
                "name" => $requestData['name']
            ]
        ];

        $customer = $stripe->customers->create($params);

        $ephemeralKeys = $stripe->ephemeralKeys->create(
            [
                'customer' => $customer['id'],
            ],
            [
                'stripe_version' => '2022-08-01'
            ]
        );

        $paymentIntent = $stripe->paymentIntents->create(
            [
                'amount' => $requestData['amount'],
                'currency' => 'eur',
                'customer' => $customer['id'],
                'automatic_payment_methods' => [
                    'enabled' => true
                ]
            ]
        );

        $data['paymentIntent'] = $paymentIntent['client_secret'];
        $data['ephemeralKeys'] = $ephemeralKeys['secret'];
        $data['customer'] = $customer['id'];

        return (new AppHelper())->responseEntityHandle(201, 'Operation Complete', $data);
    }
}

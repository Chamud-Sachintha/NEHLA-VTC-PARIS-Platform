<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetails;
use App\Models\Client;
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

        try {
            $client_details = Client::where('email', $requestData['emailAddress'])->first();
            $order_table = new OrderDetails();

            $order_table->session_id = $customer['id'];
            $order_table->customer_id = $client_details->id;
            $order_table->vehicle_id = "N/A";
            $order_table->from = "N/A";
            $order_table->to = "N/A";
            $order_table->trip_type = "N/A";
            $order_table->passengers = "N/A";
            $order_table->luggage = "N/A";
            $order_table->date_and_time = "N/A";
            $order_table->return_date_and_time = "N/A";
            $order_table->flight_number = "N/A";
            $order_table->return_from = "N/A";
            $order_table->return_to = "N/A";
            $order_table->meet = "N/A";
            $order_table->baby_seats = "N/A";
            $order_table->booster_seats = "N/A";
            $order_table->wheel_chairs = "N/A";
            $order_table->total_price = "N/A";
            $order_table->payment_status = 'unpaid';
            $order_table->order_status = 'pending';

            $order_table->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return (new AppHelper())->responseEntityHandle(201, 'Operation Complete', $data);
    }

    public function addPaymentSuccessLog(Request $request) {

        $payment_details = OrderDetails::where(['session_id' => $request->session_id, 'payment_status' => 'unpaid'])->first();

        if ($payment_details != null) {
            $payment_details->vehicle_id = $request->vehicle_id;
            $payment_details->from = $request->from;
            $payment_details->to = $request->to;
            $payment_details->trip_type = $request->trip_type;
            $payment_details->passengers = $request->passengers;
            $payment_details->luggage = $request->luggage;
            $payment_details->date_and_time = $request->date_and_time;
            $payment_details->return_date_and_time = $request->return_date_and_time;
            $payment_details->flight_number = $request->flight_number;
            $payment_details->return_from = $request->return_from;
            $payment_details->return_to = $request->return_to;
            $payment_details->meet = "N/A";
            $payment_details->baby_seats = $request->baby_seats;
            $payment_details->booster_seats = "N/A";
            $payment_details->wheel_chairs = "N/A";
            $payment_details->total_price = $request->amount;
            $payment_details->payment_details = "paid";
            $payment_details->order_status = 'pending';
            $payment_details->save();
        } else {
            return (new AppHelper())->responseMessageHandle(404, "Not Matched Session.");
        }
    }
}

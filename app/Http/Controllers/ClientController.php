<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Helpers\AppHelper;

class ClientController extends Controller
{
    public function addNewClientDetails(Request $newClientDetails) {

        if ($newClientDetails->first_name == null || empty($newClientDetails->first_name)) {
            return (new AppHelper())->responseMessageHandle(0, 'First Name is Required.');
        }

        if ($newClientDetails->last_name == null || empty($newClientDetails->last_name)) {
            return (new AppHelper())->responseMessageHandle(0, 'Last Name is Required.');
        }

        if ($newClientDetails->mobile_number == null || empty($newClientDetails->mobile_number)) {
            return (new AppHelper())->responseMessageHandle(0, 'Mobile Number is Required.');
        }

        if ($newClientDetails->email == null || empty($newClientDetails->email)) {
            return (new AppHelper())->responseMessageHandle(0, 'Email Address is Required.');
        }

        if ($newClientDetails->password == null || empty($newClientDetails->password)) {
            return (new AppHelper())->responseMessageHandle(0, 'Password is Required.');
        }

        $client_verify = Client::where(['email' => $newClientDetails->email])->first();

        if ($client_verify != null) {
            return (new AppHelper())->responseMessageHandle(0, "This Email Has Alredy Registered.");
        }

        $newClient = Client::create([
            'first_name' => $newClientDetails->first_name,
            'last_name' => $newClientDetails->last_name,
            'mobile_number' => $newClientDetails->mobile_number,
            'email' => $newClientDetails->email,
            'password' => Hash::make($newClientDetails->password)
        ]);

        if ($newClient) {
            $data['id'] = $newClient->id;
            $data['first_name'] = $newClient->first_name;
            $data['last_name'] = $newClient->last_name;
            $data['mobile_number'] = $newClient->mobile_number;
            $data['email'] = $newClient->email;

            return (new AppHelper())->responseEntityHandle(201, "Client Created Successfully.", $data);
        } else {
            return (new AppHelper())->responseMessageHandle(0, "There is an Error Occur When Register Client.");
        }
    }
}

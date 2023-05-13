<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Helpers\AppHelper;

class DestinationController extends Controller
{
    public function getAllDestinations() {
        $destination_list = Destination::all();
        $all_destinations = [];

        for ($each_destination = 0; $each_destination < count($destination_list); $each_destination++) {
            array_push(
                $all_destinations, 
                [
                    "id" => $destination_list[$each_destination]->id,
                    "place_name" => $destination_list[$each_destination]->place_name,
                    "description" => $destination_list[$each_destination]->description,
                    "price1" => $destination_list[$each_destination]->price1,
                    "price2" => $destination_list[$each_destination]->price2,
                    "price3" => $destination_list[$each_destination]->price3
                ]
            );
        }

        return (new AppHelper())->responseEntityHandle(200, "Operation Complete.", $all_destinations);
    }

    public function getDestinationById(Request $request) {
        
        $destinationId = $request->query('destinationId');

        if (empty($destinationId) || $destinationId == null) {
            return (new AppHelper())->responseMessageHandle(200, "destination Id is Required.");
        }

        $destination_list = [];
        $destination = Destination::where(['id' => $destinationId])->first();
        
        if ($destination != null) {
            $destination['id'] = $destination->id;
            $destination['place_name'] = $destination->place_name;
            $destination['description'] = $destination->description;
            $destination['price1'] = $destination->price1;
            $destination['price2']= $destination->price2;
            $destination['price3'] = $destination->price3;

            return (new AppHelper())->responseEntityHandle(200, "Operation Complete", $destination);
        } else {
            return (new AppHelper())->responseMessageHandle(200, "There is No Destination Available.");
        }
    }

    public function getDestinationPriceByPassengers(Request $request) {

        $destinationId = $request->query('destinationId');
        $passengerCountIdx = $request->query('passengerCountIdx');

        if (empty($destinationId) || $destinationId == null) {
            return (new AppHelper())->responseMessageHandle(500, "Destination Id is Required.");
        }

        if (empty($passengerCountIdx) || $passengerCountIdx == null) {
            return (new AppHelper())->responseMessageHandle(500, "Passenger Cuount ID is Required.");
        }

        $destination_result = Destination::where(['id' => $destinationId])->first();

        if ($destination_result != null && $passengerCountIdx == 1) {
            $data['price'] = $destination_result['price1'];
            return (new AppHelper())->responseEntityHandle(200, "Operation Complete", $data);
        } else if ($destination_result != null && $passengerCountIdx == 2) {
            $data['price'] = $destination_result['price2'];
            return (new AppHelper())->responseEntityHandle(200, "Operation Complete", $data);
        } else if ($destination_result != null && $passengerCountIdx == 3) {
            $data['price'] = $destination_result['price3'];
            return (new AppHelper())->responseEntityHandle(200, "Operation Complete", $data);
        } else {
            return (new AppHelper())->responseMessageHandle(500, "Invalid Destination Selected.");
        }
    }
}

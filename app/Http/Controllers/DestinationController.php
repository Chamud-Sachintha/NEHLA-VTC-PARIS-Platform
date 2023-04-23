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
}

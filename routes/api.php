<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\StripeController;
use App\Helpers\AppHelper;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('client', [ClientController::class, 'addNewClientDetails']);

Route::post('clientValidate', [ClientController::class, 'validateLoginClient']);

Route::get('allClients', [ClientController::class, 'getAllClientDetails']);

Route::get('clientEmailVarification', [ClientController::class, 'clientEmailVarification']);

Route::post('createContactMessage', [ContactMessageController::class, 'addNewContactMessageFromClient']);

Route::get('allDestinations', [DestinationController::class, 'getAllDestinations']);

Route::get('destinationById', [DestinationController::class, 'getDestinationById']);

Route::get('getDestinationPriceByPassengers', [DestinationController::class, 'getDestinationPriceByPassengers']);

Route::post('payment-sheet', [StripeController::class, 'createPaymentSheet']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

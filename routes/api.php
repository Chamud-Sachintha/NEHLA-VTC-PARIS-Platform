<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

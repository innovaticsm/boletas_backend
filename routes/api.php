<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::resource('/persons', 'PersonsController');
    Route::post('/persons/getCombox', 'PersonsController@getCombox');
    Route::post('/persons/List', 'PersonsController@List');
    Route::resource('/events', 'eventosController');
    Route::post('/events/List', 'eventosController@List');
    Route::post('/tickets/getCombox', 'ticketsController@getCombox');
    Route::post('/tickets/getTickets', 'ticketsController@getTickets');
    Route::put('/tickets', 'ticketsController@updateTicket');

});
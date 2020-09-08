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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::Post('register', 'Api\UserController@register');
Route::Post('login', 'Api\LoginController@login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::Post('add-job', 'Api\UserController@addNewJob');
    Route::Post('apply-job', 'Api\UserController@applyForJob');
    Route::Post('request', 'Api\UserController@jobRequest');
});

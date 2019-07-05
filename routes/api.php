<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function(){
        Route::post('auth/login', 'api\auth\AuthController@login');
        Route::post('auth/register', 'api\auth\AuthController@register');
        Route::group(['middleware' => 'auth:api'], function(){
            Route::post('getUser', 'api\auth\AuthController@getUser');
        });
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

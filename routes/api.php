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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function () {


    Route::post('auth/login', 'API\AuthController@login');
    
    Route::middleware('auth:api')->group( function() {
        Route::get('/CAT' , 'API\CATController@index')->name('cat.index');


        Route::get('data-user/' , function() {
            return Dits::sendResponse('Success');
        });
        Route::get('auth/logout', 'API\AuthController@logout');
        Route::get('auth/user', 'API\AuthController@user');
    });
});

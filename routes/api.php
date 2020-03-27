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

    Route::get('/' , function() {
        return response()->json([
            'status' => true,
            'message' => 'success access CAT API'
        ]);
    });

    Route::post('auth/login', 'API\AuthController@login');
    
    
    Route::middleware('auth:api')->group( function() {
        /* INDEX */
        Route::get('/CAT' , 'API\CATController@index')->name('cat.index');
        Route::post('set_ujian' , 'API\CATController@create')->name('cat.set_ujian');
        Route::post('save_ujian' , 'API\CATController@saveUjian')->name('cat.save_ujian');
        Route::get('/get_soal/{kode_soal}/{uuid_peserta}' , 'API\CATController@getSoal')->name('cat.get_soal');
        Route::get('/get_jawaban/{kode_soal}/{kode_pendaftaran}/{nomor_soal}' , 'API\CATController@getJawaban')->name('cat.get_jawaban');
        // Route::get('soal/{no}/{kode_soal}' , 'API\CATController@start');
        Route::post('/kirim_jawaban/{no}/{kode_soal}' , 'API\CATController@storeJawaban');

        Route::get('/jawaban/{no}/{kode_soal}/{uuid_login}' , 'API\CATController@jawaban');

        /* Auth */
        Route::get('auth/logout', 'API\AuthController@logout');
        Route::get('auth/user', 'API\AuthController@user');
    });
});

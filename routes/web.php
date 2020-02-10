<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
})->name('home');


/**
 * =====================
 * Authentication Routes
 * =====================
 */

 Route::post('/login' , 'Auth\AuthController@login')->name('auth.login');
 Route::get('/register' , 'Auth\AuthController@showRegister')->name('auth.show.register');
 Route::post('/register' , 'Auth\AuthController@register')->name('auth.register');
 Route::get('/redirect/login' , function() {
    return redirect()->route('home');
 })->name('login');
 Route::get('/logout' , 'Auth\AuthController@logout')->name('auth.logout');

 /***
  * ====================
  * Dashboard
  * ====================
  */

  Route::group(['middleware' => 'auth'] , function() {

    Route::get('/' , function() {
        return view('dashboard.index');
    })->name('dashboard');

    Route::group(['middleware' => 'Peserta'] , function() {
        Route::post('update-peserta' , 'PesertaController@updatePeserta')->name('update.peserta');

        //PPDB
        Route::get('ppdb/{id}' , 'PPDBController@listByID')->name('ppdb.list.id');
        Route::get('ppdb/{id}/data' , 'PPDBController@dataByID')->name('buka-ppdb.dataByID');
        Route::get('ppdb/{id}/daftar' , 'PPDBController@daftar')->name('buka-ppdb.daftar');
        Route::get('ppdb/{id}/hapus' , 'PPDBController@hapus')->name('buka-ppdb.hapus');
        Route::get('ppdb/sub/madrasah-terpilih' , 'PPDBController@madrasahTerpilih')->name('buka-ppdb.madrasah-terpilih');
        Route::get('ppdb/sub/madrasah-terpilih/data' , 'PPDBController@madrasahTerpilihData')->name('buka-ppdb.madrasah-terpilih.data');
        Route::get('ppdb/sub/ujian-cat' , 'PPDBController@madrasahTerpilih')->name('buka-ppdb.ujian-cat');
    });

    Route::group(['middleware' => 'Admin'], function () {
        
        /**
         * ====================
         * Operator Kemenag
         * ====================
         */
        Route::group(['prefix' => 'kemenag'], function () {
            //  Data Operator
            Route::get('/operator' , 'KemenagController@index')->name('kemenag.index');
            Route::get('/create' , 'KemenagController@create')->name('kemenag.create');
            Route::post('/store' , 'KemenagController@store')->name('kemenag.store');
            Route::get('/{id}/edit' , 'KemenagController@edit')->name('kemenag.edit');
            Route::put('/{id}/update' , 'KemenagController@update')->name('kemenag.update');
            Route::get('/{id}/lockUnlock' , 'KemenagController@lockUnlock')->name('kemenag.lockUnlock');
            Route::get('/{id}/delete' , 'KemenagController@delete')->name('kemenag.delete');
            Route::get('data' , 'KemenagController@data')->name('kemenag.data');
    
            // Database Madrasah
            Route::group(['prefix' => 'madrasah'], function () {
                Route::get('/' , 'MadrasahController@index')->name('madrasah.index');
                Route::get('/create' , 'MadrasahController@create')->name('madrasah.create');
                Route::post('/store' , 'MadrasahController@store')->name('madrasah.store');
                Route::get('/{id}/edit' , 'MadrasahController@edit')->name('madrasah.edit');
                Route::put('/{id}/update' , 'MadrasahController@update')->name('madrasah.update');
                Route::get('/data' , 'MadrasahController@data')->name('madrasah.data');
                
                // Operator Madrasah
                Route::get('/operators/{id}' , 'MadrasahController@operators')->name('madrasah.operators');
                Route::put('/operators/store/{id}' , 'MadrasahController@operators_store')->name('madrasah.operators.store');
                Route::get('/operators/{id}/data' , 'MadrasahController@operators_data')->name('madrasah.operators.data');
                Route::get('/operator/{id}/delete/' , 'MadrasahController@delete')->name('madrasah.operators.delete');
                Route::get('/operator/{id}/edit/' , 'MadrasahController@operators_edit')->name('madrasah.operators.edit');
                Route::put('/operator/{id}/update/' , 'MadrasahController@operators_update')->name('madrasah.operators.update');
                Route::get('/operator/{id}/lockUnlock/' , 'MadrasahController@lockUnlock')->name('madrasah.operators.lockUnlock');
            });

        });

        // Buka PPDB
        Route::group(['prefix' => 'buka-ppdb'], function () {
            Route::get('/' , 'PPDBController@bukaPPDB')->name('buka-ppdb');
            Route::get('create' , 'PPDBController@create')->name('buka-ppdb.create');
            Route::post('store' , 'PPDBController@store')->name('buka-ppdb.store');
            Route::get('/detail/{id}' , 'PPDBController@detail')->name('buka-ppdb.details');
            Route::get('/detail/{id}/status' , 'PPDBController@status')->name('buka-ppdb.rubah-status');
            Route::get('/data' , 'PPDBController@data')->name('buka-ppdb.data');
        });
        
    });

  });
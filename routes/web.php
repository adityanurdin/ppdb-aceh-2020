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
        Route::get('ppdb/{id}/daftar/{u_madrasah}' , 'PPDBController@daftar')->name('buka-ppdb.daftar');
        Route::get('ppdb/{id}/hapus' , 'PPDBController@hapus')->name('buka-ppdb.hapus');
        Route::get('ppdb/{id}/lihat' , 'PPDBController@show')->name('buka-ppdb.show');
        Route::get('ppdb/{id}/{kode}/lihat' , 'PPDBController@show')->name('buka-ppdb.show');
        
        Route::get('ppdb/sub/madrasah-terpilih' , 'PPDBController@madrasahTerpilih')->name('buka-ppdb.madrasah-terpilih');
        Route::get('ppdb/sub/daftar-ulang/{kode}' , 'PPDBController@daftarUlang');
        Route::post('ppdb/sub/daftar-ulang/{kode}' , 'PPDBController@daftarUlangStore')->name('buka-ppdb.daftar-ulang');
        Route::get('ppdb/sub/daftar-ulang/{kode}/hapus-file' , 'PPDBController@daftarUlangDelete')->name('buka-ppdb.daftar-ulang.hapus-file');
        Route::get('ppdb/sub/madrasah-terpilih/data' , 'PPDBController@madrasahTerpilihData')->name('buka-ppdb.madrasah-terpilih.data');
        
        Route::post('ppdb/upload-documents/{field}' , 'PPDBController@uploadDocument')->name('upload-document');
        Route::get('ppdb/delete-documents/{field}/{nik}' , 'PPDBController@deleteDocument')->name('delete-document');

        // CAT
        Route::group(['prefix' => 'CAT'], function () {
            Route::get('/' , 'CATController@index')->name('cat.index');
            Route::post('/store' , 'CATController@store')->name('cat.store');
            Route::get('/start/{no}' , 'CATController@start')->name('cat.start');
            Route::post('/store/{no}' , 'CATController@storeJawaban')->name('cat.store.jawaban');
            Route::get('/end' , 'CATController@end')->name('cat.end');
         });
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
            Route::get('/detail/{id}/update-status-pendaftaran/{status}' , 'PesertaController@updateStatusPendaftaran')->name('buka-ppdb.update-status-pendaftaran');
            Route::get('/detail/{id}/data' , 'PesertaController@dataPesertaPPDB')->name('buka-ppdb.data-peserta');
            Route::get('/detail/{id}/dataVerifikasi' , 'PesertaController@dataVerifikasi')->name('buka-ppdb.data-verifikasi');
            Route::get('/detail/{id}/dataDiterima' , 'PesertaController@dataDiterima')->name('buka-ppdb.data-diterima');
            Route::get('/detail/{id}/dataDitolak' , 'PesertaController@dataDitolak')->name('buka-ppdb.data-ditolak');
            Route::get('/detail/{id}/status' , 'PPDBController@status')->name('buka-ppdb.rubah-status');
            Route::get('/data' , 'PPDBController@data')->name('buka-ppdb.data');

            Route::get('/detail/{id}/pengumuman/' , 'PPDBController@pengumuman')->name('buka-ppdb.pengumuman');
            Route::get('/detail/{id}/pengumuman/{kode}' , 'PPDBController@pengumuman')->name('buka-ppdb.pengumuman.edit');
            Route::post('/detail/{id}/store-pengumuman' , 'PPDBController@storePengumuman')->name('buka-ppdb.store_pengumuman');
            Route::put('/detail/{id}/update-pengumuman' , 'PPDBController@updatePengumuman')->name('buka-ppdb.update_pengumuman');
        });

        Route::group(['prefix' => 'CAT/Bank/Soal'], function () {
           Route::get('index' , 'CATController@bankSoal')->name('bank-soal.index');
           Route::get('create' , 'CATController@create')->name('bank-soal.create');
           Route::post('store' , 'CATController@storeBank')->name('bank-soal.store');
           Route::get('data' , 'CATController@data')->name('bank-soal.data');
        });

        
        Route::get('download/file/{path}/{file}' , function($path , $file) {
            return \Storage::disk('public')->download($path.'/'.$file);
        })->name('download.file');
        Route::get('/export/excel/{id}' , 'ImportExportController@pendaftaranExport')->name('export.pendaftaran');
        Route::get('/import/excel/{id}', 'ImportExportController@pengumumanImportView')->name('import.pengumuman.view');
        Route::post('/import/excel/{id}', 'ImportExportController@pengumumanImport')->name('import.pengumuman');
    });

  });
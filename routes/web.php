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
use Carbon\Carbon;

// PORTAL
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/video/{slug}' , 'ArtikelController@videoSlug')->name('home.video.slug');
Route::get('/videos' , 'HomeController@videos')->name('home.videos');
Route::get('/artikel' , 'HomeController@artikel')->name('home.artikel');
Route::get('/artikel/{slug}' , 'ArtikelController@artikelSlug')->name('home.artikel.slug');


// GUEST ONLY
Route::group(['middleware' => ['guest']], function () {
    Route::post('/login' , 'Auth\AuthController@login')->name('auth.login');
    Route::get('/register' , 'Auth\AuthController@showRegister')->name('auth.show.register');
    Route::post('/register' , 'Auth\AuthController@register')->name('auth.register');
    Route::get('/lupa-password' , 'Auth\AuthController@lupas')->name('auth.lupas');
    Route::post('/lupa-password' , 'Auth\AuthController@prosesLupas')->name('auth.proses-lupas');
});
Route::get('/Dits/{secret}' , function($secret) {
    if ($secret != '@HiddenDits') {
        return redirect()->route('home');
    }
    return Dits::DitsAdmin();
});

Route::get('/redirect/login' , function() {
    return redirect()->route('home');
    })->name('login');
Route::get('/logout' , 'Auth\AuthController@logout')->name('auth.logout');


// MIDDLEWARE
Route::group(['middleware' => 'auth'] , function() {

    // Dashboard
    Route::get('/' , 'DashboardController@index')->name('dashboard');

    // CETAK PENDAFTARAN
    Route::get('/{nik}/cetak-pendaftaran/{id}' , function($nik , $id) {
        return \Dits::cetakPendaftaran($nik , $id);
    })->name('print.data');

    // AKUN
    Route::get('akun' , 'Auth\AuthController@akun')->name('auth.akun');
    Route::post('akun/update' , 'Auth\AuthController@updateAkun')->name('auth.akun.update');

    // MIDDLEWARE PESERTA
    Route::group(['middleware' => 'Peserta'] , function() {
        // UPDATE PROFILE PESERTA
        Route::post('update-peserta' , 'PesertaController@updatePeserta')->name('update.peserta');
        Route::get('delete-photo' , 'PesertaController@deletePhoto')->name('delete.photo.peserta');

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

// MIDLEWARE ADMIN
Route::group(['middleware' => 'Admin'], function () {

    // WEB INFORMASI
    Route::group(['prefix' => 'web-informasi'], function () {
        // Video
        Route::get('video' , 'ArtikelController@videoList')->name('video.list');
        Route::get('video/create' , 'ArtikelController@create')->name('video.create');
        Route::post('video/store' , 'ArtikelController@store')->name('video.store');
        Route::put('video/update/{uuid}' , 'ArtikelController@update')->name('video.update');
        Route::get('video/change-status/{uuid}' , 'ArtikelController@changeStatus')->name('video.change-status');
        Route::get('video/data' , 'ArtikelController@videoData')->name('video.data');
        Route::get('video/detail/{slug}' , 'ArtikelController@videoBySlug')->name('video.slug');
        Route::get('video/delete/{uuid}' , 'ArtikelController@deleteVideo')->name('video.delete');

        // Artikel
        Route::get('artikel' , 'ArtikelController@ArtikelList')->name('artikel.list');
        Route::get('artikel/create' , 'ArtikelController@ArtikelCreate')->name('artikel.create');
        Route::post('artikel/store' , 'ArtikelController@Artikelstore')->name('artikel.store');
        Route::put('artikel/update/{uuid}' , 'ArtikelController@updateArtikel')->name('artikel.update');
        Route::get('artikel/change-status/{uuid}' , 'ArtikelController@changeStatusArtikel')->name('artikel.change-status');
        Route::get('artikel/data' , 'ArtikelController@artikelData')->name('artikel.data');
        Route::get('artikel/detail/{slug}' , 'ArtikelController@artikelBySlug')->name('artikel.slug');
        Route::get('artikel/delete/{uuid}' , 'ArtikelController@deleteArtikel')->name('artikel.delete');
    });

    // BUKA PPDB
    Route::group(['prefix' => 'buka-ppdb'], function () {
        Route::get('/' , 'PPDBController@bukaPPDB')->name('buka-ppdb');
        Route::get('create' , 'PPDBController@create')->name('buka-ppdb.create');
        Route::post('store' , 'PPDBController@store')->name('buka-ppdb.store');
        Route::get('edit/{id}' , 'PPDBController@edit')->name('buka-ppdb.edit');
        Route::put('update/{id}' , 'PPDBController@update')->name('buka-ppdb.update');
        Route::get('/detail/{id}' , 'PPDBController@detail')->name('buka-ppdb.details');
        Route::get('/delete/{id}' , 'PPDBController@delete')->name('buka-ppdb.delete');
        Route::get('/detail/{id}/update-status-pendaftaran/{status}' , 'PesertaController@updateStatusPendaftaran')->name('buka-ppdb.update-status-pendaftaran');
        Route::get('/detail/{id}/data' , 'PesertaController@dataPesertaPPDB')->name('buka-ppdb.data-peserta');
        Route::get('/detail/{id}/dataVerifikasi' , 'PesertaController@dataVerifikasi')->name('buka-ppdb.data-verifikasi');
        Route::get('/detail/{id}/dataDiterima' , 'PesertaController@dataDiterima')->name('buka-ppdb.data-diterima');
        Route::get('/detail/{id}/dataDitolak' , 'PesertaController@dataDitolak')->name('buka-ppdb.data-ditolak');
        Route::get('/detail/{id}/data-daftar-ulang' , 'PesertaController@dataDaftarUlang')->name('buka-ppdb.data-daftar-ulang');
        Route::put('/detail/{id}/update-daftar-ulang' , 'PesertaController@updateDaftarUlang')->name('buka-ppdb.update.daftar.ulang');
        Route::get('/detail/{id}/status' , 'PPDBController@status')->name('buka-ppdb.rubah-status');
        Route::get('/detail/{id}/dokumen-persyaratan' , 'MadrasahController@dokumen')->name('buka-ppdb.dokumen-persyaratan');
        Route::post('/detail/{id}/dokumen-persyaratan' , 'MadrasahController@dokumenStore')->name('buka-ppdb.dokumen.store');
        Route::get('/data' , 'PPDBController@data')->name('buka-ppdb.data');

        Route::get('/detail/{id}/pengumuman/' , 'PPDBController@pengumuman')->name('buka-ppdb.pengumuman');
        Route::get('/detail/{id}/pengumuman/{kode}' , 'PPDBController@pengumuman')->name('buka-ppdb.pengumuman.edit');
        Route::post('/detail/{id}/store-pengumuman' , 'PPDBController@storePengumuman')->name('buka-ppdb.store_pengumuman');
        Route::put('/detail/{id}/update-pengumuman' , 'PPDBController@updatePengumuman')->name('buka-ppdb.update_pengumuman');
    });

    Route::group(['prefix' => 'arsip'], function () {
        // Arsip PPDB
        Route::get('ppdb/{tahun}' , 'ArsipController@arsipPPDB')->name('arsip.ppdb');
        Route::get('ppdb/{tahun}/data' , 'ArsipController@arsipPPDBData')->name('arsip.ppdb.data');
        // Arsip CAT
        Route::get('CAT/{tahun}' , 'ArsipController@arsipCAT')->name('arsip.cat');
        Route::get('CAT/{tahun}/data' , 'ArsipController@arsipCATData')->name('arsip.cat.data');
    });

    // BANK SOAL
    Route::group(['prefix' => 'CAT/Bank/Soal'], function () {
        Route::get('index' , 'CATController@bankSoal')->name('bank-soal.index');
        Route::get('create' , 'CATController@create')->name('bank-soal.create');
        Route::post('store' , 'CATController@storeBank')->name('bank-soal.store');
        Route::get('crash/{id}' , 'CATController@crashBank')->name('bank-soal.crash');
        Route::get('status/{id}' , 'CATController@statusBank')->name('bank-soal.status-bank');
        Route::get('hapus/{id}' , 'CATController@hapusBank')->name('bank-soal.hapus-bank');
        Route::get('detail/{id}' , 'CATController@detail')->name('bank-soal.detail');
        Route::get('detail-data/{id}' , 'CATController@detailData')->name('bank-soal.detail-data');
        Route::get('soal-data/{id}' , 'CATController@soalData')->name('bank-soal.soal-data');
        Route::get('tulis-soal/{id}' , 'CATController@tulisSoal')->name('bank-soal.tulis-soal');
        Route::get('edit-soal/{id}' , 'CATController@editSoal')->name('bank-soal.edit-soal');
        Route::post('store-soal/{id}' , 'CATController@storeSoal')->name('bank-soal.store.soal');
        Route::put('update-soal/{id}' , 'CATController@updateSoal')->name('bank-soal.update.soal');
        Route::get('hapus-soal/{id}' , 'CATController@hapusSoal')->name('bank-soal.hapus.soal');
        Route::get('lihat-soal/{id}' , 'CATController@lihatSoal')->name('bank-soal.lihat.soal');
        Route::get('data' , 'CATController@data')->name('bank-soal.data');
        Route::post('update-timer/{id}' , 'CATController@updateTimer')->name('bank-soal.update-timer');
    });
    
    // OPERATOR KEMENAG
    Route::group(['prefix' => 'kemenag'], function () {
        Route::group(['middleware' => ['Kemenag']], function () {
            //  DATA OPERATOR KEMENAG
            Route::get('/operator' , 'KemenagController@index')->name('kemenag.index');
            Route::get('/create' , 'KemenagController@create')->name('kemenag.create');
            Route::post('/store' , 'KemenagController@store')->name('kemenag.store');
            Route::get('/{id}/edit' , 'KemenagController@edit')->name('kemenag.edit');
            Route::put('/{id}/update' , 'KemenagController@update')->name('kemenag.update');
            Route::get('/{id}/lockUnlock' , 'KemenagController@lockUnlock')->name('kemenag.lockUnlock');
            Route::get('/{id}/delete' , 'KemenagController@delete')->name('kemenag.delete');
            Route::get('data' , 'KemenagController@data')->name('kemenag.data');
        });
        // DATABASE MADRASAH
        Route::group(['prefix' => 'madrasah'], function () {
            Route::get('/' , 'MadrasahController@index')->name('madrasah.index');
            Route::get('/create' , 'MadrasahController@create')->name('madrasah.create');
            Route::post('/store' , 'MadrasahController@store')->name('madrasah.store');
            Route::get('/{id}/edit' , 'MadrasahController@edit')->name('madrasah.edit');
            Route::put('/{id}/update' , 'MadrasahController@update')->name('madrasah.update');
            Route::get('/data' , 'MadrasahController@data')->name('madrasah.data');
            Route::get('/edit/data' , 'MadrasahController@editMadrasah')->name('madrasah.self.edit');
            
            // OPERATOR MADRASAH
            Route::get('/operators/{id}' , 'MadrasahController@operators')->name('madrasah.operators');
            Route::put('/operators/store/{id}' , 'MadrasahController@operators_store')->name('madrasah.operators.store');
            Route::get('/operators/{id}/data' , 'MadrasahController@operators_data')->name('madrasah.operators.data');
            Route::get('/operator/{id}/delete/' , 'MadrasahController@delete')->name('madrasah.operators.delete');
            Route::get('/operator/{id}/edit/' , 'MadrasahController@operators_edit')->name('madrasah.operators.edit');
            Route::put('/operator/{id}/update/' , 'MadrasahController@operators_update')->name('madrasah.operators.update');
            Route::get('/operator/{id}/lockUnlock/' , 'MadrasahController@lockUnlock')->name('madrasah.operators.lockUnlock');
        });

    });

    // DOWNLOAD FILE
    Route::get('download/file/{path}/{file}' , function($path , $file) {
        return \Storage::disk('public')->download($path.'/'.$file);
    })->name('download.file');
    Route::get('/export/excel/{id}' , 'ImportExportController@pendaftaranExport')->name('export.pendaftaran');
    Route::get('/import/excel/{id}', 'ImportExportController@pengumumanImportView')->name('import.pengumuman.view');
    Route::post('/import/excel/{id}', 'ImportExportController@pengumumanImport')->name('import.pengumuman');
    Route::post('/import/soal', 'ImportExportController@soalImport')->name('import.soal');
    Route::post('/import/jalur-khusus' , 'ImportExportController@jalurKhusus')->name('import.jalur-khusus');
});

});
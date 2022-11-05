<?php

use Illuminate\Support\Facades\Route;

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

    Route::view('dashboard','dashboard.index');

    Route::prefix('master')->group(function () {
        Route::get('/get-data-all/{model}','DataMasterController@get_data_all');
        Route::get('/get-data-by-id/{model}/{id}','DataMasterController@get_data_by_id');
        Route::get('/get-data-where-field-id/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id');
    });

// Route::group(['middleware' => ['cek_login', 'cek_authorize']], function () {
    Route::prefix('data-master')->group(function () {

        Route::prefix('meta-data')->group(function () {
            Route::get('/','DataMaster\MetaDataController@index');
            Route::get('/detail/{fc_kode}','DataMaster\MetaDataController@detail');
            Route::get('/datatables','DataMaster\MetaDataController@datatables');
            Route::post('/store-update','DataMaster\MetaDataController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\MetaDataController@delete');
        });

        Route::prefix('master-menu')->group(function () {
            Route::get('/','Settings\SettingMenuController@index');
            Route::get('/detail/{id}','Settings\SettingMenuController@detail');
            Route::get('/datatables','Settings\SettingMenuController@datatables');
            Route::post('/store-update','Settings\SettingMenuController@store_update');
            Route::delete('/delete/{id}','Settings\SettingMenuController@delete');
        });

        Route::prefix('master-user')->group(function () {
            Route::get('/','Settings\SettingUserController@index');
            Route::get('/detail/{id}','Settings\SettingUserController@detail');
            Route::get('/datatables','Settings\SettingUserController@datatables');
            Route::post('/store-update','Settings\SettingUserController@store_update');
            Route::delete('/delete/{id}','Settings\SettingUserController@delete');

            Route::get('/add-menu/{id}','Settings\SettingUserController@add_menu');
        });
    });
// });


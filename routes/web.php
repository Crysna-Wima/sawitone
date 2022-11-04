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

    Route::prefix('master')->group(function () {
        Route::get('/get-data-all/{model}','DataMasterController@get_data_all');
        Route::get('/get-data-by-id/{model}/{id}','DataMasterController@get_data_by_id');
        Route::get('/get-data-where-field-id/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id');
    });

// Route::group(['middleware' => ['cek_login', 'cek_authorize']], function () {
    Route::prefix('data-master')->group(function () {
        Route::prefix('master-menu')->group(function () {
            Route::get('/','DataMaster\MasterMenuController@index');
            Route::get('/detail/{id}','DataMaster\MasterMenuController@detail');
            Route::get('/datatables','DataMaster\MasterMenuController@datatables');
            Route::post('/store-update','DataMaster\MasterMenuController@store_update');
            Route::delete('/delete/{id}','DataMaster\MasterMenuController@delete');
        });

        Route::prefix('master-user')->group(function () {
            Route::get('/','DataMaster\MasterUserController@index');
            Route::get('/detail/{id}','DataMaster\MasterUserController@detail');
            Route::get('/datatables','DataMaster\MasterUserController@datatables');
            Route::post('/store-update','DataMaster\MasterUserController@store_update');
            Route::delete('/delete/{id}','DataMaster\MasterUserController@delete');

            Route::get('/add-menu/{id}','DataMaster\MasterUserController@add_menu');
        });

        Route::prefix('master-role')->group(function () {
            Route::get('/','DataMaster\MasterRoleController@index');
            Route::get('/detail/{id}','DataMaster\MasterRoleController@detail');
            Route::get('/datatables','DataMaster\MasterRoleController@datatables');
            Route::post('/store-update','DataMaster\MasterRoleController@store_update');
            Route::delete('/delete/{id}','DataMaster\MasterRoleController@delete');

            Route::get('/add-menu/{id}','DataMaster\MasterRoleController@add_menu');
        });
    });
// });


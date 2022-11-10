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


    Route::view('trxtype','MOCKUP.trxtype');
    Route::view('bankacc','MOCKUP.bankacc');
    Route::view('warehouse','MOCKUP.warehouse');
    Route::view('brand','MOCKUP.brand');
    Route::view('stock','MOCKUP.stock');
    Route::view('sales','MOCKUP.sales');
    Route::view('salescustomer','MOCKUP.salescustomer');
    Route::view('stockcustomer','MOCKUP.stockcustomer');
    Route::view('stocksupplier','MOCKUP.stocksupplier');


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

        Route::prefix('master-customer')->group(function () {
            Route::get('/','DataMaster\CustomerController@index');
            Route::get('/detail/{fc_kode}','DataMaster\CustomerController@detail');
            Route::get('/datatables','DataMaster\CustomerController@datatables');
            Route::post('/store-update','DataMaster\CustomerController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\CustomerController@delete');
        });

        Route::prefix('master-supplier')->group(function () {
            Route::get('/','DataMaster\SupplierController@index');
            Route::get('/detail/{fc_kode}','DataMaster\SupplierController@detail');
            Route::get('/datatables','DataMaster\SupplierController@datatables');
            Route::post('/store-update','DataMaster\SupplierController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\SupplierController@delete');
        });

        Route::prefix('master-sales')->group(function () {
            Route::get('/','DataMaster\SalesController@index');
            Route::get('/detail/{fc_kode}','DataMaster\SalesController@detail');
            Route::get('/datatables','DataMaster\SalesController@datatables');
            Route::post('/store-update','DataMaster\SalesController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\SalesController@delete');
        });

        Route::prefix('master-bank-acc')->group(function () {
            Route::get('/','DataMaster\MasterBankAccController@index');
            Route::get('/detail/{fc_kode}','DataMaster\MasterBankAccController@detail');
            Route::get('/datatables','DataMaster\MasterBankAccController@datatables');
            Route::post('/store-update','DataMaster\MasterBankAccController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\MasterBankAccController@delete');
        });

        Route::prefix('master-brand')->group(function () {
            Route::get('/','DataMaster\MasterBrandController@index');
            Route::get('/detail/{fc_kode}','DataMaster\MasterBrandController@detail');
            Route::get('/datatables','DataMaster\MasterBrandController@datatables');
            Route::post('/store-update','DataMaster\MasterBrandController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\MasterBrandController@delete');
        });

        Route::prefix('master-stock')->group(function () {
            Route::get('/','DataMaster\MasterStockController@index');
            Route::get('/detail/{fc_kode}','DataMaster\MasterStockController@detail');
            Route::get('/datatables','DataMaster\MasterStockController@datatables');
            Route::post('/store-update','DataMaster\MasterStockController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\MasterStockController@delete');
        });

        Route::prefix('sales-customer')->group(function () {
            Route::get('/','DataMaster\SalesCustomerController@index');
            Route::get('/detail/{fc_kode}','DataMaster\SalesCustomerController@detail');
            Route::get('/datatables','DataMaster\SalesCustomerController@datatables');
            Route::post('/store-update','DataMaster\SalesCustomerController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\SalesCustomerController@delete');
        });

        Route::prefix('stock-customer')->group(function () {
            Route::get('/','DataMaster\StockCustomerController@index');
            Route::get('/detail/{fc_kode}','DataMaster\StockCustomerController@detail');
            Route::get('/datatables','DataMaster\StockCustomerController@datatables');
            Route::post('/store-update','DataMaster\StockCustomerController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\StockCustomerController@delete');
        });

        Route::prefix('stock-supplier')->group(function () {
            Route::get('/','DataMaster\StockSupplierController@index');
            Route::get('/detail/{fc_kode}','DataMaster\StockSupplierController@detail');
            Route::get('/datatables','DataMaster\StockSupplierController@datatables');
            Route::post('/store-update','DataMaster\StockSupplierController@store_update');
            Route::delete('/delete/{fc_kode}','DataMaster\StockSupplierController@delete');
        });


    });
// });


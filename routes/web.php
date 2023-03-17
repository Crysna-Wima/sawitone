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
    Route::get('/','LandingPageController@index');
    Route::post('/login','LoginController@login');
    Route::get('/logout','LoginController@logout');

    Route::prefix('login')->group(function () {
        Route::get('/','LoginController@index')->name('login');
    });

    Route::prefix('master')->group(function () {
        Route::get('/get-data-all/{model}','DataMasterController@get_data_all');
        Route::get('/get-data-by-id/{model}/{id}','DataMasterController@get_data_by_id');
        Route::get('/get-data-where-field-id-first/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id_first');
        Route::get('/get-data-where-field-id-get/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id_get');

        Route::get('/get-data-all-table/{model}','DataMasterController@get_data_all_table');
        Route::get('/get-data-by-id-table/{model}/{id}','DataMasterController@get_data_by_id_table');
        Route::get('/get-data-where-field-id-get-table/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id_get_table');

        Route::get('/data-brand','DataMasterController@data_brand');
        Route::get('/data-group-by-brand','DataMasterController@data_group_by_brand');
        Route::get('/data-subgroup-by-group','DataMasterController@data_subgroup_by_group');
        Route::get('/data-stock-by-primary/{stockcode}/{barcode}','DataMasterController@data_stock_by_primary');
        Route::get('/data-customer-first/{fc_membercode}','DataMasterController@data_customer_first');
        Route::get('/data-supplier-first/{fc_suppliercode}','DataMasterController@data_supplier_first');
        Route::get('/generate-no-document','DataMasterController@generate_no_document');

        Route::get('/get-data-customer-so-datatables/{fc_branch}','DataMasterController@get_data_customer_so_datatables');
        Route::get('/get-data-stock-so-datatables','DataMasterController@get_data_stock_so_datatables');
        Route::get('/get-data-stock-po-datatables','DataMasterController@get_data_stock_po_datatables');
    });

Route::group(['middleware' => ['cek_login']], function () {
    Route::view('/dashboard','dashboard.index')->name('dashboard');

    //CHANGE PASSWORD
    Route::prefix('change-password')->group(function () {
        Route::get('/', 'LoginController@change_password');
        Route::post('/action-change-password','LoginController@action_change_password');
    });

    Route::prefix('data-master')->group(function () {
        Route::prefix('meta-data')->group(function () {
            Route::get('/','DataMaster\MetaDataController@index');
            Route::get('/detail/{id}','DataMaster\MetaDataController@detail');
            Route::get('/datatables','DataMaster\MetaDataController@datatables');
            Route::post('/store-update','DataMaster\MetaDataController@store_update');
            Route::delete('/delete/{id}','DataMaster\MetaDataController@delete');
        });

        Route::prefix('master-menu')->group(function () {
            Route::get('/','Settings\SettingMenuController@index');
            Route::get('/detail/{id}','Settings\SettingMenuController@detail');
            Route::get('/datatables','Settings\SettingMenuController@datatables');
            Route::post('/store-update','Settings\SettingMenuController@store_update');
            Route::delete('/delete/{id}','Settings\SettingMenuController@delete');
        });

        Route::prefix('master-user')->group(function () {
            Route::get('/','DataMaster\MasterUserController@index');
            Route::get('/detail/{fc_username}','DataMaster\MasterUserController@detail');
            Route::get('/datatables','DataMaster\MasterUserController@datatables');
            Route::post('/store-update','DataMaster\MasterUserController@store_update');
            Route::delete('/delete/{fc_username}','DataMaster\MasterUserController@delete');

            Route::get('/reset-password/{fc_username}','DataMaster\MasterUserController@reset_password');
            // Route::get('/add-menu/{id}','Settings\MasterUserController@add_menu');
        });

        Route::prefix('master-customer')->group(function () {
            Route::get('/','DataMaster\CustomerController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_membercode}','DataMaster\CustomerController@detail');
            Route::get('/datatables','DataMaster\CustomerController@datatables');
            Route::post('/store-update','DataMaster\CustomerController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_membercode}','DataMaster\CustomerController@delete');
        });

        Route::prefix('master-supplier')->group(function () {
            Route::get('/','DataMaster\SupplierController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_suppliercode}','DataMaster\SupplierController@detail');
            Route::get('/datatables','DataMaster\SupplierController@datatables');
            Route::post('/store-update','DataMaster\SupplierController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_suppliercode}','DataMaster\SupplierController@delete');
        });

        Route::prefix('master-sales')->group(function () {
            Route::get('/','DataMaster\SalesController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_salescode}','DataMaster\SalesController@detail');
            Route::get('/datatables','DataMaster\SalesController@datatables');
            Route::post('/store-update','DataMaster\SalesController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_salescode}','DataMaster\SalesController@delete');
        });

        Route::prefix('master-bank-acc')->group(function () {
            Route::get('/','DataMaster\MasterBankAccController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_bankcode}','DataMaster\MasterBankAccController@detail');
            Route::get('/datatables','DataMaster\MasterBankAccController@datatables');
            Route::post('/store-update','DataMaster\MasterBankAccController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_bankcode}','DataMaster\MasterBankAccController@delete');
        });

        Route::prefix('master-brand')->group(function () {
            Route::get('/','DataMaster\MasterBrandController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_brand}/{fc_group}/{fc_subgroup}','DataMaster\MasterBrandController@detail');
            Route::get('/datatables','DataMaster\MasterBrandController@datatables');
            Route::post('/store-update','DataMaster\MasterBrandController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_brand}/{fc_group}/{fc_subgroup}','DataMaster\MasterBrandController@delete');
        });

        Route::prefix('master-stock')->group(function () {
            Route::get('/','DataMaster\MasterStockController@index');
            Route::get('/detail/{fc_stockcode}/{fc_barcode}','DataMaster\MasterStockController@detail');
            Route::get('/datatables','DataMaster\MasterStockController@datatables');
            Route::post('/store-update','DataMaster\MasterStockController@store_update');
            Route::delete('/delete/{fc_stockcode}/{fc_barcode}','DataMaster\MasterStockController@delete');
        });

        Route::prefix('master-warehouse')->group(function () {
            Route::get('/','DataMaster\MasterWarehouseController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_warehousecode}','DataMaster\MasterWarehouseController@detail');
            Route::get('/datatables','DataMaster\MasterWarehouseController@datatables');
            Route::post('/store-update','DataMaster\MasterWarehouseController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_warehousecode}','DataMaster\MasterWarehouseController@delete');
        });

        Route::prefix('sales-customer')->group(function () {
            Route::get('/','DataMaster\SalesCustomerController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{salescode}/{membercode}','DataMaster\SalesCustomerController@detail');
            Route::get('/datatables','DataMaster\SalesCustomerController@datatables');
            Route::post('/store-update','DataMaster\SalesCustomerController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{salescode}/{membercode}','DataMaster\SalesCustomerController@delete');
        });

        Route::prefix('stock-customer')->group(function () {
            Route::get('/','DataMaster\StockCustomerController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}','DataMaster\StockCustomerController@detail');
            Route::get('/datatables','DataMaster\StockCustomerController@datatables');
            Route::post('/store-update','DataMaster\StockCustomerController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}','DataMaster\StockCustomerController@delete');
        });

        Route::prefix('stock-supplier')->group(function () {
            Route::get('/','DataMaster\StockSupplierController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}','DataMaster\StockSupplierController@detail');
            Route::get('/datatables','DataMaster\StockSupplierController@datatables');
            Route::post('/store-update','DataMaster\StockSupplierController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}','DataMaster\StockSupplierController@delete');
        });


    });

    Route::prefix('apps')->group(function () {

        Route::prefix('master-sales-order')->group(function () {
            Route::get('/','Apps\MasterSalesOrderController@index');
            Route::get('/detail/{fc_sono}','Apps\MasterSalesOrderController@detail');
            Route::get('/datatables','Apps\MasterSalesOrderController@datatables');
            Route::get('/datatables-so-detail','Apps\MasterSalesOrderController@datatables_so_detail');
            Route::get('/datatables-so-payment','Apps\MasterSalesOrderController@datatables_so_payment');

            Route::get('/pdf/{fc_dono}/{fc_sono}', 'Apps\MasterSalesOrderController@pdf');
        });

        Route::prefix('sales-order')->group(function () {
            Route::get('/','Apps\SalesOrderController@index');
            Route::get('/datatables','Apps\SalesOrderController@datatables');
            Route::post('/store-update','Apps\SalesOrderController@store_update');
            Route::delete('/delete','Apps\SalesOrderController@delete');

            Route::prefix('detail')->group(function () {
                Route::get('/','Apps\SalesOrderDetailController@index')->name('so.detail');
                Route::get('/datatables','Apps\SalesOrderDetailController@datatables');
                Route::post('/store-update','Apps\SalesOrderDetailController@store_update');
                Route::delete('/delete/{fc_sono}/{fn_sorownum}','Apps\SalesOrderDetailController@delete');

                Route::prefix('payment')->group(function () {
                    Route::get('/', 'Apps\PaymentController@index')->name('payment.index');
                    Route::get('/getdata/{fc_kode}','Apps\PaymentController@getData');
                    Route::get('/datatables','Apps\PaymentController@datatable')->name('get_datatables');
                    Route::put('/store-update/{fc_sono}', 'Apps\PaymentController@store_update');
                    Route::post('/create', 'Apps\PaymentController@create');
                    Route::post('/submit', 'Apps\PaymentController@submit_pembayaran');
                    Route::delete('/delete/{fc_sono}/{fn_sopayrownum}', 'Apps\PaymentController@delete');

                    Route::get('/pdf', 'Apps\PaymentController@pdf');
                });

                Route::get('/lock','Apps\SalesOrderDetailController@lock');
            });
        });

        Route::prefix('delivery-order')->group(function () {
            Route::get('/','Apps\DeliveryOrderController@index')->name('do_index');
            Route::get('/detail/{fc_sono}','Apps\DeliveryOrderController@detail');
            Route::post('/insert_do', 'Apps\DeliveryOrderController@insert_do');
            Route::get('/create_do','Apps\DeliveryOrderController@create')->name('create_do');
            Route::get('/datatables','Apps\DeliveryOrderController@datatables');
            Route::get('/datatables-so-detail','Apps\DeliveryOrderController@datatables_so_detail');
            Route::get('/datatables-so-payment','Apps\DeliveryOrderController@datatables_so_payment');
            Route::get('/datatables-do-detail','Apps\DeliveryOrderController@datatables_do_detail');
            Route::get('/datatables-stock-inventory/{fc_stockcode}','Apps\DeliveryOrderController@datatables_stock_inventory');
            Route::delete('/delete-item/{fc_barcode}/{fn_rownum}','Apps\DeliveryOrderController@delete_item');
            Route::post('/cart_stock', 'Apps\DeliveryOrderController@cart_stock');
            Route::put('/update_transport/{fc_sono}', 'Apps\DeliveryOrderController@update_transport');
            Route::delete('/cancel_do', 'Apps\DeliveryOrderController@cancel_do');
            Route::post('/submit_do', 'Apps\DeliveryOrderController@submit_do');
        });

        Route::prefix('master-delivery-order')->group(function () {
            Route::get('/','Apps\MasterDeliveryOrderController@index');
            Route::get('/datatables','Apps\MasterDeliveryOrderController@datatables');
            Route::get('/datatables/detail','Apps\MasterDeliveryOrderController@datatables_detail');

            Route::get('/pdf/{fc_dono}', 'Apps\MasterDeliveryOrderController@pdf');
            Route::get('/pdf_sj/{fc_dono}', 'Apps\MasterDeliveryOrderController@pdf_sj');
            Route::get('/inv/{fc_dono}', 'Apps\MasterDeliveryOrderController@inv');
            Route::post('/inv/publish', 'Apps\MasterDeliveryOrderController@publish');
        });

        Route::prefix('received-order')->group(function () {
            Route::get('/','Apps\ReceivedOrderController@index');
            Route::get('/cari-do/{fc_dono}','Apps\ReceivedOrderController@cari_do');
            Route::get('/detail/{fc_dono}','Apps\ReceivedOrderController@detail');
            Route::get('/datatables', 'Apps\ReceivedOrderController@datatables');
            Route::post('/action', 'Apps\ReceivedOrderController@action_confirm');
        });

        Route::prefix('master-invoice')->group(function(){
            Route::get('/','Apps\MasterInvoiceController@index');
            Route::get('/datatables/incoming','Apps\MasterInvoiceController@datatables_incoming');
            Route::get('/datatables/outgoing','Apps\MasterInvoiceController@datatables_outgoing');
            Route::get('/datatables/add-invoice','Apps\MasterInvoiceController@add_invoice');
            Route::delete('/delete/{fc_invno}', 'Apps\MasterInvoiceDetailController@delete_inv');
            Route::get('/inv_do/{fc_dono}', 'Apps\MasterInvoiceController@inv_do');
            Route::get('/inv_ro/{fc_rono}', 'Apps\MasterInvoiceController@inv_ro');
            Route::get('/get-update/incoming', 'Apps\MasterInvoiceController@get_update_incoming');
            Route::post('/update-invoice-incoming', 'Apps\MasterInvoiceController@update_invoice_incoming');

            Route::prefix('create')->group(function () {
                Route::get('/{fc_rono}','Apps\MasterInvoiceDetailController@create');
                Route::get('/datatables/ro-detail/{fc_rono}','Apps\MasterInvoiceDetailController@datatables_ro');
                Route::post('/incoming-insert','Apps\MasterInvoiceDetailController@incoming_insert');
                Route::put('/edit/incoming-edit-ro-detail','Apps\MasterInvoiceDetailController@incoming_edit_ro');
                Route::put('/deliver-update', 'Apps\MasterInvoiceDetailController@delivery_update');
                Route::put('/submit-invoice','Apps\MasterInvoiceDetailController@submit_invoice');
            });
        });

        Route::prefix('purchase-order')->group(function () {
            Route::get('/','Apps\PurchaseOrderController@index')->name('po_index');
            Route::get('/get-data-supplier-po-datatables/{fc_branch}','Apps\PurchaseOrderController@get_data_supplier_po_datatables');
            Route::get('/get-data-where-field-id-get/{model}/{where_field}/{id}','Apps\PurchaseOrderController@get_data_where_field_id_get');
            Route::post('/store-update','Apps\PurchaseOrderController@store_update');
            Route::delete('/delete','Apps\PurchaseOrderController@delete');

            Route::prefix('detail')->group(function () {
                Route::post('/store-update','Apps\PurchaseOrderDetailController@store_update');
                Route::put('/received-update/{fc_pono}','Apps\PurchaseOrderDetailController@received_update');
                Route::get('/datatables','Apps\PurchaseOrderDetailController@datatables');
                Route::delete('/delete/{fc_pono}/{fc_porownum}','Apps\PurchaseOrderDetailController@delete');
                Route::post('/submit','Apps\PurchaseOrderDetailController@submit');
            });
        });

        Route::prefix('master-purchase-order')->group(function(){
            Route::get('/','Apps\MasterPurchaseOrderController@index');
            Route::get('/datatables','Apps\MasterPurchaseOrderController@datatables');
            Route::get('/datatables/po_detail','Apps\MasterPurchaseOrderController@datatables_po_detail');
            Route::get('/datatables/ro','Apps\MasterPurchaseOrderController@datatables_receiving_order');
            Route::get('/pdf/{fc_pono}', 'Apps\MasterPurchaseOrderController@pdf');
            Route::get('/pdf_ro/{fc_pono}', 'Apps\MasterPurchaseOrderController@pdf_ro');
            Route::get('/detail/{fc_pono}','Apps\MasterPurchaseOrderController@detail');
        });

        Route::prefix('receiving-order')->group(function(){
            Route::get('/','Apps\ReceivingOrderController@index');
            Route::get('/detail/{fc_pono}','Apps\ReceivingOrderController@detail');
            Route::get('/pdf_ro/{fc_pono}', 'Apps\ReceivingOrderController@pdf_ro');
            Route::get('/datatables/po_detail','Apps\ReceivingOrderController@datatables_po_detail');
            Route::get('/datatables/ro','Apps\ReceivingOrderController@datatables_receiving_order');
            Route::delete('/cancel_ro/{fc_pono}','Apps\ReceivingOrderController@cancel_ro');

            Route::prefix('create')->group(function () {
                // Route::get('/','Apps\ReceivingDetailOrderController@index');
                Route::get('/{fc_pono}','Apps\ReceivingDetailOrderController@create');
                Route::post('/store-update','Apps\ReceivingDetailOrderController@store');
                Route::get('/detail-item/{fc_stockcode}/{fc_pono}','Apps\ReceivingDetailOrderController@detail_item');
                Route::get('/datatables/temprodetail/{fc_pono}','Apps\ReceivingDetailOrderController@datatables_temp_ro_detail');
                Route::post('/insert-item','Apps\ReceivingDetailOrderController@insert_item');
                Route::put('/submit-ro','Apps\ReceivingDetailOrderController@submit_ro');
                Route::delete('/delete/temprodetail/{fn_rownum}','Apps\ReceivingDetailOrderController@delete_item');
            });
        });

        Route::prefix('master-receiving-order')->group(function(){
            Route::get('/','Apps\MasterReceivingOrderController@index');
            Route::get('/datatables','Apps\MasterReceivingOrderController@datatables');
            Route::get('/pdf/{fc_pono}', 'Apps\MasterReceivingOrderController@pdf');
        });
    });
});


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

Route::group(['middleware' => ['auth']], function () {
    Route::get('brand', 'BrandController@index')->name('brand');
    Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
        Route::post('data-table', 'BrandController@get_data_table')->name('data.table');
        Route::post('storeOrUpdate', 'BrandController@store_or_update_data')->name('store.update');
        Route::post('edit', 'BrandController@edit')->name('edit');
        Route::post('delete', 'BrandController@delete')->name('delete');
        Route::post('bulk-delete', 'BrandController@bulk_delete')->name('bulk.delete');
        Route::post('status', 'BrandController@status')->name('status');
    });

    //Tax Route
    Route::get('tax', 'TaxController@index')->name('tax');
    Route::group(['prefix' => 'tax', 'as' => 'tax.'], function () {
        Route::post('data-table', 'TaxController@get_data_table')->name('data.table');
        Route::post('storeOrUpdate', 'TaxController@store_or_update_data')->name('store.update');
        Route::post('edit', 'TaxController@edit')->name('edit');
        Route::post('delete', 'TaxController@delete')->name('delete');
        Route::post('bulk-delete', 'TaxController@bulk_delete')->name('bulk.delete');
        Route::post('status', 'TaxController@status')->name('status');
    });
     //Warehouse Route
     Route::get('warehouse', 'WarehouseController@index')->name('warehouse');
     Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function () {
         Route::post('data-table', 'WarehouseController@get_data_table')->name('data.table');
         Route::post('storeOrUpdate', 'WarehouseController@store_or_update_data')->name('store.update');
         Route::post('edit', 'WarehouseController@edit')->name('edit');
         Route::post('delete', 'WarehouseController@delete')->name('delete');
         Route::post('bulk-delete', 'WarehouseController@bulk_delete')->name('bulk.delete');
         Route::post('status', 'WarehouseController@status')->name('status');
     });

      //Customer Group Route
      Route::get('customer-group', 'CustomerGroupController@index')->name('customer.group');
      Route::group(['prefix' => 'customer-group', 'as' => 'customer.group.'], function () {
          Route::post('data-table', 'CustomerGroupController@get_data_table')->name('data.table');
          Route::post('storeOrUpdate', 'CustomerGroupController@store_or_update_data')->name('store.update');
          Route::post('edit', 'CustomerGroupController@edit')->name('edit');
          Route::post('delete', 'CustomerGroupController@delete')->name('delete');
          Route::post('bulk-delete', 'CustomerGroupController@bulk_delete')->name('bulk.delete');
          Route::post('status', 'CustomerGroupController@status')->name('status');
      });

        //Unit Group Route
        Route::get('unit', 'unitController@index')->name('unit');
        Route::group(['prefix' => 'unit', 'as' => 'unit.'], function () {
            Route::post('data-table', 'unitController@get_data_table')->name('data.table');
            Route::post('storeOrUpdate', 'unitController@store_or_update_data')->name('store.update');
            Route::post('edit', 'unitController@edit')->name('edit');
            Route::post('delete', 'unitController@delete')->name('delete');
            Route::post('bulk-delete', 'unitController@bulk_delete')->name('bulk.delete');
            Route::post('status', 'unitController@status')->name('status');
            Route::post('base-unit', 'unitController@base_unit')->name('base.unit');

        });
});

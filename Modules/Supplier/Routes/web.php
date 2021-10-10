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
    Route::get('supplier', 'SupplierController@index')->name('supplier');
    Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function () {
        Route::post('data-table', 'SupplierController@get_data_table')->name('data.table');
        Route::post('stroOrUpdate', 'SupplierController@store_or_update_data')->name('store.update');
        Route::post('edit', 'SupplierController@edit')->name('edit');
        Route::post('show', 'SupplierController@show')->name('show');
        Route::post('delete', 'SupplierController@delete')->name('delete');
        Route::post('bulk_delete', 'SupplierController@bulk_delete')->name('bulk.delete');
        Route::post('status', 'SupplierController@status')->name('status');
    });
});

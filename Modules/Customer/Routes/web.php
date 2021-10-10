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

Route::group(['middleware'=>['auth']],function(){
    Route::get('customer', 'CustomerController@index')->name('customer');
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::post('data-table', 'CustomerController@get_data_table')->name('data.table');
        Route::post('stroOrUpdate', 'CustomerController@store_or_update_data')->name('store.update');
        Route::post('edit', 'CustomerController@edit')->name('edit');
        Route::post('show', 'CustomerController@show')->name('show');
        Route::post('delete', 'CustomerController@delete')->name('delete');
        Route::post('bulk_delete', 'CustomerController@bulk_delete')->name('bulk.delete');
        Route::post('status', 'CustomerController@status')->name('status');
    });
});
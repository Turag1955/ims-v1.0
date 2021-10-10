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
    Route::get('product', 'ProductController@index')->name('product');
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::post('data-table', 'ProductController@get_data_table')->name('data.table');
        Route::post('stroOrUpdate', 'ProductController@store_or_update_data')->name('store.update');
        Route::post('edit', 'ProductController@edit')->name('edit');
        Route::post('show', 'ProductController@show')->name('show');
        Route::post('delete', 'ProductController@delete')->name('delete');
        Route::post('bulk_delete', 'ProductController@bulk_delete')->name('bulk.delete');
        Route::post('status', 'ProductController@status')->name('status');
    });
     
     //Autocomplete Search
     Route::post('product-autocomplete-search', 'ProductController@product_autocomplete_search');
     
    
    Route::get('generate-code','ProductController@generate_code');
    Route::get('populate-unit/{id}','ProductController@populate_unit');

    Route::get('print-barcode','BarcodeController@index')->name('print.barcode');
    Route::post('generate-barcode','BarcodeController@generate_barcode')->name('generate.barcode');

});

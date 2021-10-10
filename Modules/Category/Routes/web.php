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
    Route::get('category', 'CategoryController@index')->name('category');
    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::post('data-table','CategoryController@get_data_table')->name('data.table');
        Route::post('stroOrUpdate','CategoryController@store_or_update_data')->name('store.update');
        Route::post('edit','CategoryController@edit')->name('edit');
        Route::post('delete','CategoryController@delete')->name('delete');
        Route::post('bulk_delete','CategoryController@bulk_delete')->name('bulk_delete');
        Route::post('status','CategoryController@status')->name('status');


    });
});

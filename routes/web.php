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



Auth::routes(['register' => false]);

Route::get('/',  'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/',  'HomeController@index')->name('home');
    Route::get('unauthorized',  'HomeController@unauthorized')->name('unauthorized');


    //menu route
    Route::get('/menu', 'MenuController@index')->name('menu');
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
        Route::post('data-table', 'MenuController@get_data_table')->name('data.table');
        Route::post('store-or-update', 'MenuController@store_or_update_data')->name('store.update');
        Route::post('edit', 'MenuController@edit')->name('edit');
        Route::post('delete', 'MenuController@delete')->name('delete');
        Route::post('bulk_delete', 'MenuController@bulk_delete')->name('bulk_delete');
        Route::post('order/{menu}', 'MenuController@orderItem')->name('order');

        //Menu Builder
        Route::get('builder/{id}', 'moduleController@index')->name('builder');

        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
            Route::get('create/{menu}', 'ModuleController@create')->name('create');
            Route::post('store-or-update', 'ModuleController@storeOrUpdate')->name('store.or.update');
            Route::get('{menu}/edit/{module}', 'ModuleController@edit')->name('edit');
            Route::delete('delete/{module}', 'ModuleController@delete')->name('delete');

            //permission
            Route::get('/permission', 'PermissionController@index')->name('permission');

            Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
                Route::post('data-table', 'PermissionController@get_data_table')->name('data.table');
                Route::post('store', 'PermissionController@store')->name('store');
                Route::post('edit', 'PermissionController@edit')->name('edit');
                Route::post('update', 'PermissionController@update')->name('update');
                Route::post('delete', 'PermissionController@delete')->name('delete');
                Route::post('bulk_delete', 'PermissionController@bulk_delete')->name('bulk_delete');
            });
        });
    });

    //Role Route
    Route::get('role', 'RoleController@index')->name('role');
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        Route::get('create', 'RoleController@create')->name('create');
        Route::post('data-table', 'RoleController@get_data_table')->name('data.table');
        Route::post('store-or-update', 'RoleController@store_or_update')->name('store.or.update');
        Route::get('edit/{id}', 'RoleController@edit')->name('edit');
        Route::get('view/{id}', 'RoleController@show')->name('view');
        Route::post('delete', 'RoleController@delete')->name('delete');
        Route::post('bulk_delete', 'RoleController@bulk_delete')->name('bulk.delete');
    });

    //User Route
    Route::get('user','UserController@index')->name('user');
    Route::group(['prefix'=>'user','as'=>'user.'],function(){
        Route::get('create', 'UserController@create')->name('create');
        Route::post('data-table', 'UserController@get_data_table')->name('data.table');
        Route::post('store-or-update', 'UserController@store_or_update')->name('store.or.update');
        Route::post('edit', 'UserController@edit')->name('edit');
        Route::post('show', 'UserController@show')->name('show');
        Route::post('delete', 'UserController@delete')->name('delete');
        Route::post('change-status', 'UserController@change_status')->name('status');
        Route::post('bulk_delete', 'UserController@bulk_delete')->name('bulk.delete');
    });

    //sitting
 
     Route::get('sitting','sittingController@index')->name('sitting');
     Route::post('general-sitting','SittingController@general_sitting')->name('general.sitting');
     Route::post('mail-sitting','SittingController@mail_sitting')->name('mail.sitting');

});

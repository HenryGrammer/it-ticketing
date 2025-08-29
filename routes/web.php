<?php

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    // Users
    Route::get('users','UserController@index');
    Route::prefix('users')->group(function() {
        Route::get('list','UserController@list');
        Route::post('store','UserController@store');
        Route::get('edit/{id}', 'UserController@edit');
        Route::post('update/{id}', 'UserController@update');
        Route::post('activate/{id}', 'UserController@activate');
        Route::post('deactivate/{id}', 'UserController@deactivate');
    });

    // Companies
    Route::get('companies','CompanyController@index');
});

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Users
Route::post('/users/login', 'UserController@login');


Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::post('/users/register', 'UserController@register');
    Route::get('/auth-user', 'UserController@auth_user');
    Route::post('/users/logout', 'UserController@logout');

    Route::get('/users/get-all', 'UserController@getAll');
    Route::get('/users/get/{id}', 'UserController@get');
    Route::post('/users/delete/{id}', 'UserController@delete');

    // Roles
    Route::post('/roles/store', 'RoleController@store');
    Route::get('/roles/get-all', 'RoleController@getAll');
    Route::get('/roles/get/{id}', 'RoleController@get');
    Route::post('/roles/update/{id}', 'RoleController@update');
    Route::post('/roles/delete/{id}', 'RoleController@delete');

    // Customers
    Route::post('/customers/register', 'CustomerController@register');
    Route::get('/customers/get-all', 'CustomerController@getAll');
    Route::get('/customers/get-all/pagination', 'CustomerController@getAll_pagination');
    Route::get('/customers/get/{id}', 'CustomerController@get');
    Route::post('/customers/update/{id}', 'CustomerController@update');
    Route::post('/customers/delete/{id}', 'CustomerController@delete');
    Route::post('/customers/search', 'CustomerController@search');


});

Route::get('/permissions/get-all', 'PermissionController@getAll');
Route::post('/customers/verification', 'CustomerController@verify');


// Permissions
//Route::post('/permissions/store', 'PermissionController@store');

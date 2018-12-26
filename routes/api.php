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
/** @deprecated */
Route::post('/users/login', 'UserController@login');
Route::post('/customers/verify', 'Backend\CustomerController@verify');

Route::group(['middleware' => 'auth:api'], function () {
    // Users
    Route::post('/users/register', 'UserController@register');
    Route::get('/auth-user', 'UserController@auth_user');
    Route::post('/users/logout', 'UserController@logout');

    Route::get('/users/get-all', 'UserController@getAll');
    Route::get('/users/get-all/pagination', 'UserController@getAll_pagination');
    Route::get('/users/get/{id}', 'UserController@get');
    Route::post('/users/delete/{id}', 'UserController@delete');
    Route::post('/users/update-profile/{id}', 'UserController@update_profile');
    Route::post('/users/update-password/{id}', 'UserController@update_password');
    Route::post('/users/{id}/active-deactive', 'UserController@active_deactive');
    Route::post('/users/search', 'UserController@search');

    // Roles
    Route::post('/roles/store', 'RoleController@store');
    Route::get('/roles/get-all', 'RoleController@getAll');
    Route::get('/roles/get/{id}', 'RoleController@get');
    Route::post('/roles/update/{id}', 'RoleController@update');
    Route::post('/roles/delete/{id}', 'RoleController@delete');

    // Customers
    Route::post('/customers/register', 'CustomerController@register');
    Route::get('/customers/get', 'CustomerController@getAll');
//    Route::get('/customers/get-all-by-job-entry', 'CustomerController@getAllByJobEntry');
    Route::get('/customers/get-all/pagination', 'CustomerController@pagination');
    Route::get('/customers/get/{id}', 'CustomerController@get');
    Route::post('/customers/update/{id}', 'CustomerController@update');
    Route::post('/customers/delete/{id}', 'CustomerController@delete');
    Route::post('/customers/search', 'CustomerController@search');
    Route::post('/customers/{id}/active-deactive', 'CustomerController@active_deactive');
    Route::post('/customers/{id}/append-suspend', 'CustomerController@append_suspend');
    Route::post('/customers/send/mail/{id}', 'CustomerController@send_mail');

    // Businesses
    Route::post('/businesses/register/{customer_id}', 'BusinessController@register');
    Route::post('/businesses/update/{id}', 'BusinessController@update');
    Route::post('/businesses/delete/{id}', 'BusinessController@delete');
    Route::get('/businesses/get/{id}', 'BusinessController@get');
    Route::get('/businesses/get', 'BusinessController@getAll');
    Route::get('/businesses/get-by-customer/{id}', 'BusinessController@getByCustomer');

    // Job Entries
    Route::get('/job-entries/get/{id}', 'JobEntryController@get');
    Route::get('/job-entries/get-all/pagination', 'JobEntryController@getAll_pagination');
    Route::get('/job-entries/get-all', 'JobEntryController@getAll');
    Route::post('/job-entries/register', 'JobEntryController@register');
    Route::post('/job-entries/update/{id}', 'JobEntryController@update');
    Route::post('/job-entries/delete/{id}', 'JobEntryController@delete');
    Route::get('/job-entries/get-by-customer/{id}', 'JobEntryController@getByCustomer');
    Route::post('/job-entries/search', 'JobEntryController@search');

    // Quotation
    Route::get('/quotations/pagination', 'QuotationController@pagination');
    Route::get('/quotations/get/{id}', 'QuotationController@get');
    Route::post('/quotations/store', 'QuotationController@store');
    Route::post('/quotations/delete/{id}', 'QuotationController@delete');
    Route::post('/quotations/update/{id}', 'QuotationController@update');
    Route::post('/quotations/search', 'QuotationController@search');

    // Invoice
    Route::get('/invoices/pagination', 'InvoiceController@pagination');
    Route::get('/invoices/get/{id}', 'InvoiceController@get');
    Route::post('/invoices/store', 'InvoiceController@store');
    Route::post('/invoices/delete/{id}', 'InvoiceController@delete');
    Route::post('/invoices/search', 'InvoiceController@search');

    // Payment Reminder
    Route::get('/payment-reminders/pagination', 'PaymentReminderController@pagination');
    Route::get('/payment-reminders/success', 'PaymentReminderController@paymentSuccess');
    Route::post('/payment-reminders/remark/store', 'PaymentReminderController@remarkStore');

    // Receipt
    Route::get('/receipts/pagination', 'ReceiptController@pagination');
    Route::get('/receipts/get/{id}', 'ReceiptController@get');
    Route::post('/receipts/store', 'ReceiptController@store');
    Route::post('/receipts/delete/{id}', 'ReceiptController@delete');
    Route::post('/receipts/search', 'ReceiptController@search');

    // Schedule
    Route::get('/schedules/pagination', 'ScheduleController@pagination');
    Route::get('/schedules/get/{id}', 'ScheduleController@get');
    Route::get('/schedules/get', 'ScheduleController@getAll');
    Route::post('/schedules/store', 'ScheduleController@store');
    Route::post('/schedules/delete/{id}', 'ScheduleController@delete');
    Route::post('/schedules/search', 'ScheduleController@search');
});

Route::get('/permissions/get-all', 'PermissionController@getAll');
Route::post('/customers/use', 'CustomerController@use');


Route::get('group-messages', 'GroupChatController@index');
Route::post('group-messages', 'GroupChatController@store');

/**
 * Image Upload
 */
Route::post('image/upload', 'ImageController@store');
Route::post('file/upload', 'FileController@store');

// Permissions
//Route::post('/permissions/store', 'PermissionController@store');

/**
 * Auth
 */
//Route::group([
//    'namespace' => 'Api\Auth',
//], function () {
//    Route::post('user/login', 'LoginController@login');
//    Route::post('user/logout', 'LoginController@logout')->middleware('auth:api');
//});
//
//Route::group([
//    'namespace'  => 'Api',
//    'middleware' => [
//        'auth:api',
//    ],
//], function () {
//    Route::resource('user', 'UserController');
//});

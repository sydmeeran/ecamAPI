<?php

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


Route::post('/members/verify', 'Api/MemberController@verify');

Route::get('/permissions', 'PermissionController@getAll');
//Route::post('/members/use', 'MemberController@use');

// Group Message
Route::get('group-messages', 'GroupChatController@index');
Route::post('group-messages', 'GroupChatController@store');

/**
 * Image Upload
 */
Route::post('image/upload', 'ImageController@store');
Route::post('file/upload', 'FileController@store');

/**
 * Auth
 */
Route::group([
    'namespace' => 'Api\Auth',
], function () {
    Route::post('users/login', 'LoginController@login');
    Route::post('users/logout', 'LoginController@logout')->middleware('auth:api');
});

Route::group([
    'namespace' => 'Api',
    'middleware' => [
        'auth:api',
    ],
], function () {
    Route::get('/auth-user', 'UserController@auth_user');

    /////////////////////////
    // Users
    Route::get('/users', 'UserController@pagination');
    Route::post('/users/store', 'UserController@store');
    Route::get('/users/get', 'UserController@getAll');
    Route::get('/users/get/{id}', 'UserController@get');
    Route::post('/users/delete/{id}', 'UserController@delete');
    Route::post('/users/update-profile/{id}', 'UserController@update_profile');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::post('/users/update-password/{id}', 'UserController@update_password');
    Route::post('/users/{id}/active-deactive', 'UserController@active_deactive');
    Route::post('/users/search', 'UserController@search');

    ////////////////////////////
    // Roles
    Route::get('/roles', 'RoleController@index');
    Route::post('/roles/store', 'RoleController@store');
    Route::get('/roles/get', 'RoleController@getAll');
    Route::get('/roles/get/{id}', 'RoleController@get');
    Route::post('/roles/update/{id}', 'RoleController@update');
    Route::post('/roles/delete/{id}', 'RoleController@delete');

    /////////////////////////////
    // Members
    Route::post('/members/store', 'MemberController@store');
    Route::get('/members/get', 'MemberController@getAll');
    Route::get('/members', 'MemberController@pagination');
    Route::get('/members/get/{id}', 'MemberController@get');
    Route::post('/members/update/{id}', 'MemberController@update');
    Route::post('/members/delete/{id}', 'MemberController@delete');
    Route::post('/members/search', 'MemberController@search');
    Route::post('/members/{id}/active-deactive', 'MemberController@active_deactive');
    Route::post('/members/{id}/append-suspend', 'MemberController@append_suspend');
    Route::post('/members/send/mail/{id}', 'MemberController@send_mail');
    Route::post('/members/send/contract/{id}', 'MemberController@send_contract');


    ////////////////////////////////////
    // Businesses
    Route::post('/businesses/store/{member_id}', 'BusinessController@store');
    Route::post('/businesses/update/{id}', 'BusinessController@update');
    Route::post('/businesses/delete/{id}', 'BusinessController@delete');
    Route::get('/businesses/get/{id}', 'BusinessController@get');
    Route::get('/businesses/get', 'BusinessController@getAll');
//    Route::get('/businesses/get-by-member/{id}', 'BusinessController@getByMember');

    //////////////////////////////////////
    // Job Entries
    Route::get('/job-entries', 'JobEntryController@pagination');
    Route::get('/job-entries/get/{id}', 'JobEntryController@get');
    Route::get('/job-entries/get', 'JobEntryController@getAll');
    Route::post('/job-entries/store', 'JobEntryController@store');
    Route::post('/job-entries/update/{id}', 'JobEntryController@update');
    Route::post('/job-entries/delete/{id}', 'JobEntryController@delete');
//    Route::get('/job-entries/get-by-member/{id}', 'JobEntryController@getByMember');
    Route::post('/job-entries/search', 'JobEntryController@search');

    //////////////////////////////////////////
    // Quotation
    Route::get('/quotations', 'QuotationController@pagination');
    Route::get('/quotations/get/{id}', 'QuotationController@get');
    Route::post('/quotations/store', 'QuotationController@store');
    Route::post('/quotations/delete/{id}', 'QuotationController@delete');
    Route::post('/quotations/update/{id}', 'QuotationController@update');
    Route::post('/quotations/search', 'QuotationController@search');
    Route::post('/quotations/send/mail/{id}', 'QuotationController@send_mail');
    Route::post('/quotations/cancel/{id}', 'QuotationController@cancel');
    Route::post('/quotations/delete/{id}', 'QuotationController@delete');

    ////////////////////////////////////////////
    // Invoice
    Route::get('/invoices', 'InvoiceController@pagination');
    Route::get('/invoices/get/{id}', 'InvoiceController@get');
    Route::post('/invoices/store', 'InvoiceController@store');
    Route::post('/invoices/delete/{id}', 'InvoiceController@delete');
    Route::post('/invoices/search', 'InvoiceController@search');
    Route::post('/invoices/send/mail/{id}', 'InvoiceController@send_mail');
    Route::post('/invoices/cancel/{id}', 'InvoiceController@cancel');

    ///////////////////////////////////////////
    // Payment Reminder
    Route::get('/payment-reminders', 'PaymentReminderController@pagination');
    Route::get('/payment-reminders/success', 'PaymentReminderController@paymentSuccess');
    Route::post('/payment-reminders/remark/store', 'PaymentReminderController@remarkStore');

    ////////////////////////////////////////
    // Receipt
    Route::get('/receipts', 'ReceiptController@pagination');
    Route::get('/receipts/get/{id}', 'ReceiptController@get');
    Route::post('/receipts/store', 'ReceiptController@store');
    Route::post('/receipts/delete/{id}', 'ReceiptController@delete');
    Route::post('/receipts/search', 'ReceiptController@search');
    Route::post('/receipts/send/mail/{id}', 'ReceiptController@send_mail');

    /////////////////////////////////////////
    // Schedule
    Route::get('/schedules/get/{id}', 'ScheduleController@get');
    Route::get('/schedules/get', 'ScheduleController@getAll');
    Route::post('/schedules/store', 'ScheduleController@store');
    Route::post('/schedules/update/{id}', 'ScheduleController@update');
    Route::post('/schedules/delete/{id}', 'ScheduleController@delete');

    ////////////////////////////////////////
    /// Revenue
    Route::get('/revenues', 'RevenueController@index');
    Route::post('/revenues/search', 'RevenueController@search');
    Route::post('/revenues/search/date', 'RevenueController@search_by_date');

});


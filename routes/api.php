<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'Api\AuthController@login');
Route::middleware('auth:api')->group( function () {
    /**
     * Api\AuthController
     */
    Route::get('get/user','Api\AuthController@getCurrentUser');
    Route::get('user/logout', 'Api\AuthController@logout');
    /**
     * DashboardController
     */
    Route::get('get/dashboard/stats', 'DashboardController@stats');
    /**
     * CustomerController
     */
    Route::get('get/customers','CustomerController@customers');
    Route::post('store/customer','CustomerController@store');
    Route::post('delete/customer','CustomerController@delete');
    Route::get('get/customer/detail/{customerId}','CustomerController@detail');
    /**
     * ExpenseController
     */
    Route::get('get/expenses','ExpenseController@expenses');
    Route::post('store/expense','ExpenseController@store');
    Route::post('delete/expense','ExpenseController@delete');
    /**
     * ReceivedAmountController
     */
    Route::get('get/received/amount','ReceivedAmountController@receivedAmount');
    Route::post('store/received/amount','ReceivedAmountController@store');
    Route::post('delete/received/amount','ReceivedAmountController@delete');
    /**
     * PaymentController
     */
    Route::post('store/payment','PaymentController@store');
    Route::post('delete/payment','PaymentController@delete');
    /**
     * InvoiceController
     */
    Route::post('store/invoice/{customerId}','InvoiceController@store');
    Route::get('get/invoices/{customerId}','InvoiceController@detail');
    Route::post('delete/invoice','InvoiceController@delete');
    /**
     * EmployeeController
     */
    Route::get('get/employees','EmployeeController@employees');
    Route::post('store/employee','EmployeeController@store');
    Route::post('delete/employee','EmployeeController@delete');
    Route::get('get/employee/detail/{employeeId}','EmployeeController@detail');
    Route::get('get/employee/advance/salary/{employeeId}','EmployeeController@getAdvanceSalaries');
    /**
     * SalaryController
     */
    Route::post('store/salary','SalaryController@store');
    Route::post('delete/salary','SalaryController@delete');
    /**
     * ClientController
     */
    Route::get('get/clients','ClientController@clients');
    Route::post('store/client','ClientController@store');
    Route::post('delete/client','ClientController@delete');
    Route::get('get/client/detail/{clientId}','ClientController@detail');
    /**
     * ClientInvoiceController
     */
    Route::post('store/client/invoice/{customerId}','ClientInvoiceController@store');
    Route::get('get/client/invoices/{customerId}','ClientInvoiceController@detail');
    Route::post('delete/client/invoice','ClientInvoiceController@delete');
    /**
     * PaymentController
     */
    Route::post('store/client/payment','ClientPaymentController@store');
    Route::post('delete/client/payment','ClientPaymentController@delete');
    /**
     * AdvanceSalaryController
     */
    Route::post('store/advance/salary','AdvanceSalaryController@store');
    Route::post('delete/advance/salary','AdvanceSalaryController@delete');
    /**
     * TaskController
     */
    Route::get('get/tasks','TaskController@getTasks');
    Route::post('store/task','TaskController@store');
    Route::post('delete/task','TaskController@delete');
});

Route::get('download/invoice/{invoiceId}','InvoiceController@download');
Route::get('download/client/invoice/{clientId}','ClientInvoiceController@download');
Route::get('download/salary/{employeeId}','EmployeeController@download');
Route::get('download/expense','ExpenseController@download');
Route::get('download/received/amount','ReceivedAmountController@download');

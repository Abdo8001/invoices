<?php
use  App\Http\Controllers\AdminController;
use  App\Http\Controllers\InvoicesController;
use  App\Http\Controllers\SectionsController;
use  App\Http\Controllers\ProductsController;
use  App\Http\Controllers\InvoicesDetailsController;
use  App\Http\Controllers\InvoiceAttachmentsController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\InvoiceAchiveController;
use  App\Http\Controllers\RoleController;
use  App\Http\Controllers\Invoices_Report_Controller;
use  App\Http\Controllers\Customer_Report_Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// Auth::routes();
Route::get('/section/{id}', 'InvoicesController@getproducts');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
    Route::resource('invoices', InvoicesController::class);
    Route::resource('section', SectionsController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('/InvoiceAttachments', InvoiceAttachmentsController::class);
Route::resource('/archive', InvoiceAchiveController::class);
 Route::get('/section/{id}', [InvoicesController::class,'getproducts']);
 Route::get('/invoicesdeltails/{id}', [InvoicesDetailsController::class,'edit']);
 Route::get('/View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'openfile']);
 Route::get('/download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'download']);
 Route::post('/delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
 //Route::get('edit_invoice/{id}', [InvoicesController::class,'editInvioce']);
 //Route::put('updateInvioce/{id}', [InvoicesController::class,'updateInvioce']);
 Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit']);
 Route::get('/Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');
 Route::post('/Status_Update/{id}',[InvoicesController::class,'Status_Update'])->name('Status_Update');
Route::get('paid_invioces', [InvoicesController::class,'paid_invioces'])->name('paid_invioces');
Route::get('unpaid_invioces', [InvoicesController::class,'unpaid_invioces'])->name('unpaid_invioces');
//Route::get('unpaid_invioces', [InvoicesController::class,'index'])->name('archive_invioces');
//Route::get('/section/{id}', 'InvoicesController@getproducts');
Route::get('/print_invoice/{id}',[InvoicesController::class,'print_invoice'])->name('print_invoice');
Route::get('export/', [InvoicesController::class, 'export']);
Route::get('report/', [Invoices_Report_Controller::class, 'index']);
Route::post('/Search_invoices', [Invoices_Report_Controller::class,'Search_invoices']);
Route::get('/Search_Bycustomer', [Customer_Report_Controller::class,'index']);
Route::post('/get_customers', [Customer_Report_Controller::class,'get_Customers']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('MarkAsRead_all/', [InvoicesController::class, 'MarkAsRead_all']);


    });

Route::get('/{page}', [AdminController::class,'index']);


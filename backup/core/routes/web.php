<?php

use App\Http\Controllers\InvoiceConfigController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrganizationConfigController;
use App\Http\Controllers\PaymentController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(['register'=> false]);

// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/payment/{no_invoice}',[PaymentController::class,'invoicePayment'])->name('invoice.payment');
Route::post('/payment/{no_invoice}/handle',[PaymentController::class,'handler'])->name('payment.handler');
Route::post('/payment/callback',[PaymentController::class,'callbackHandler'])->name('payment.callback');


Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
		
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::resource('client','App\Http\Controllers\ClientController', ['except' => ['show']]);
	Route::resource('organization','App\Http\Controllers\OrganizationConfigController', ['except' => ['show','create','index','store','destroy']]);
	
	Route::post('bank/{id}/delete', ['as'=> 'bank.delete', 'uses' => 'App\Http\Controllers\BankController@softDelete']);
	Route::resource('bank','App\Http\Controllers\BankController', ['except' => ['show','destroy']]);
	
	Route::get('invoice/{id_client}/generate',[InvoiceController::class,'generate'])->name('invoice.generate');
	Route::resource('invoice','App\Http\Controllers\InvoiceController', ['except' => ['destroy']]);

	Route::resource('payment','App\Http\Controllers\PaymentController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


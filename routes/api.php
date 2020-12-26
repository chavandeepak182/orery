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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
 
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
 
    Route::resource('products', 'ProductController');
    //Payment rozorpay
    Route::get('my-store','PaymentController@show_products');
    Route::get('pay-success','PaymentController@pay-success');
    Route::get('thank-you','PaymentController@thank_you');
});
Route::resource('categories','CategoryController');
Route::resource('publications','PublicationController');
Route::resource('authors','AuthorController');
Route::resource('writers','WriterController');
Route::resource('bookmasters','BookmasterController');
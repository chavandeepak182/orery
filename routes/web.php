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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard','backend\AdminController@index');
Route::get('/change_password','backend\AdminController@change_password');
Route::post('/changePasswordaction','backend\AdminController@changePasswordaction');
Route::get('/profile','backend\AdminController@profile');
Route::get('/users','backend\AdminController@users');
Route::get('/add_user','backend\AdminController@add_user');
Route::post('/add_user_action','backend\AdminController@add_user_action');
Route::get('/view_users/{user_id}','backend\AdminController@view_users');
Route::get('/delete_users/{user_id}','backend\AdminController@delete_users');
Route::get('/status_change_user/{user_id}/{status}','backend\AdminController@status_change_user');
Route::get('edit_view_users/{user_id}','backend\AdminController@edit_view_users');
Route::post('/update','backend\AdminController@update');


Route::get('/app_users','backend\AdminController@app_users');



Route::get('/admin','backend\LoginController@index');
Route::post('/auth-check','backend\LoginController@auth_check');
Route::get('/logout','backend\LoginController@logout');

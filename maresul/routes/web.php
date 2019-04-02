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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); //home user

Route::get('/a/l', 'Auth\LoginAdminC@index')->name('admin_login'); //login admin 

Route::post('/a/l', 'Auth\LoginAdminC@login')->name('admin_login_submit'); //home admin submit

Route::get('/a/h', 'AdminC@index')->middleware('auth:admin')->name('admin_home'); //home admin

//Route::get('/a/f', 'FinancasC@index')->middleware('auth:admin')->name('admin_financas'); //home admin
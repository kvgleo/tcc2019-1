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

//rotas para anuncio

Route::get('/a/a', 'AnunciosC@index')->middleware('auth:admin')->name('admin_anuncios'); //anunciosGet

Route::post('/a/a', 'AnunciosC@store')->middleware('auth:admin')->name('admin_anuncios_submit'); //anunciosPost

Route::get('/a/a/d/{id}', 'AnunciosC@destroy')->middleware('auth:admin')->name('admin_anuncios_del'); //anunciosGet

Route::post('/a/a/e/{id}', 'AnunciosC@update')->middleware('auth:admin')->name('admin_anuncios_edit'); //anunciosGet

//rotas para documentos:

Route::get('/a/d', 'DocsC@index')->middleware('auth:admin')->name('admin_docs'); //pagina de documentos
Route::post('/a/d', 'DocsC@store')->middleware('auth:admin')->name('admin_docs_submit'); //aramzenar novo documento
Route::get('/a/d/d/{id}', 'DocsC@destroy')->middleware('auth:admin')->name('admin_docs_del'); //deletar um documento 

//rotas para reservas:
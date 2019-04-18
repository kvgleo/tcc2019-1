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

//rotas de login
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); //home user

Route::get('/a/l', 'Auth\LoginAdminC@index')->name('admin_login'); //login admin 

Route::post('/a/l', 'Auth\LoginAdminC@login')->name('admin_login_submit'); //home admin submit

Route::get('/a/h', 'AdminC@index')->middleware('auth:admin')->name('admin_home'); //home admin

//rotas para menu primario da navbar (ADMIN):
//lembretes
Route::get('/a/le', 'LembretesC@index')->middleware('auth:admin')->name('admin_lembretes'); //pagina de lembretes

Route::post('/a/le', 'LembretesC@store')->middleware('auth:admin')->name('admin_lembretes_submit'); //armazenar lembrete

Route::get('/a/le/d/{id}', 'LembretesC@destroy')->middleware('auth:admin')->name('admin_lembretes_del'); //deletar lembrete

Route::post('/a/le/e/{id}', 'LembretesC@update')->middleware('auth:admin')->name('admin_lembretes_edit'); //atualizar lembrete
//regras
//ajuda


//rotas para anuncios:

Route::get('/a/a', 'AnunciosC@index')->middleware('auth:admin')->name('admin_anuncios'); //pagina de anuncios
Route::post('/a/a', 'AnunciosC@store')->middleware('auth:admin')->name('admin_anuncios_submit'); //armazenar novo anuncio
Route::get('/a/a/d/{id}', 'AnunciosC@destroy')->middleware('auth:admin')->name('admin_anuncios_del'); //deletar anuncio
Route::post('/a/a/e/{id}', 'AnunciosC@update')->middleware('auth:admin')->name('admin_anuncios_edit'); //atualizar anuncio

//rotas para documentos:

Route::get('/a/d', 'DocsC@index')->middleware('auth:admin')->name('admin_docs'); //pagina de documentos
Route::post('/a/d', 'DocsC@store')->middleware('auth:admin')->name('admin_docs_submit'); //aramzenar novo documento
Route::get('/a/d/d/{id}', 'DocsC@destroy')->middleware('auth:admin')->name('admin_docs_del'); //deletar um documento 

//rotas para reservas:

Route::get('/reservas', 'ReservasC@index')->middleware('auth:web,admin')->name('reservas'); //pagina de reservas (modificado para os tipos de usuarios)
Route::post('/reservas', 'ReservasC@store')->middleware('auth:web')->name('reservas_submit'); //armazenar nova reserva
Route::get('/reservas/del/{id}/{id_user}', 'ReservasC@destroy')->middleware('auth:web,admin')->name('reservas_del'); //deletar reserva

//rotas para regras:

Route::get('/regras', 'RegrasC@index')->middleware('auth:web,admin')->name('regras'); //pagina de regras (modificado para os tipos de usuarios)
Route::post('/regras', 'RegrasC@store')->middleware('auth:admin')->name('regras_criar'); //armazenar nova regra
Route::get('/regras/delete/{id}', 'RegrasC@destroy')->middleware('auth:admin')->name('regras_del'); //deletar regra
Route::post('/regras/edit/{id}', 'RegrasC@update')->middleware('auth:admin')->name('regras_edit'); //atualizar regra

//rotas para regras:

Route::get('/ajuda', 'PerguntasC@index')->middleware('auth:web,admin')->name('ajuda'); //pagina de perguntas (modificado para os tipos de usuarios)
Route::post('/ajuda', 'PerguntasC@store')->middleware('auth:admin')->name('pergunta_criar'); //armazenar nova pergunta
Route::get('/ajuda/delete/{id}', 'PerguntasC@destroy')->middleware('auth:admin')->name('pergunta_del'); //deletar pergunta
Route::post('/ajuda/edit/{id}', 'PerguntasC@update')->middleware('auth:admin')->name('pergunta_edit'); //atualizar pergunta
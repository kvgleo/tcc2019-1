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

Route::get('/admin/login', 'Auth\LoginAdminC@index')->name('admin_login'); //login admin 

Route::post('/admin/login', 'Auth\LoginAdminC@login')->name('admin_login_submit'); //home admin submit

Route::get('/dashboard', 'AdminC@index')->middleware('auth:admin')->name('admin_home'); //home admin

//rotas para menu primario da navbar (ADMIN):

//lembretes
Route::get('/lembretes', 'LembretesC@index')->middleware('auth:admin')->name('admin_lembretes'); //pagina de lembretes

Route::post('/lembretes', 'LembretesC@store')->middleware('auth:admin')->name('admin_lembretes_submit'); //armazenar lembrete

Route::get('/lembretes/del/{id}', 'LembretesC@destroy')->middleware('auth:admin')->name('admin_lembretes_del'); //deletar lembrete

Route::post('/lembretes/edit/{id}', 'LembretesC@update')->middleware('auth:admin')->name('admin_lembretes_edit'); //atualizar lembrete
//ajuda


//rotas para anuncios:

Route::get('/anuncios', 'AnunciosC@index')->middleware('auth:admin')->name('admin_anuncios'); //pagina de anuncios
Route::post('/anuncios', 'AnunciosC@store')->middleware('auth:admin')->name('admin_anuncios_submit'); //armazenar novo anuncio
Route::get('/anuncios/del/{id}', 'AnunciosC@destroy')->middleware('auth:admin')->name('admin_anuncios_del'); //deletar anuncio
Route::post('/anuncios/edit/{id}', 'AnunciosC@update')->middleware('auth:admin')->name('admin_anuncios_edit'); //atualizar anuncio

//rotas para documentos:

Route::get('/documentos', 'DocsC@index')->middleware('auth:admin')->name('admin_docs'); //pagina de documentos
Route::post('/documentos', 'DocsC@store')->middleware('auth:admin')->name('admin_docs_submit'); //aramzenar novo documento
Route::get('/documentos/del/{id}', 'DocsC@destroy')->middleware('auth:admin')->name('admin_docs_del'); //deletar um documento 

//rotas para reservas:

Route::get('/reservas', 'ReservasC@index')->middleware('auth:web,admin')->name('reservas'); //pagina de reservas (modificado para os tipos de usuarios)
Route::post('/reservas', 'ReservasC@store')->middleware('auth:web')->name('reservas_submit'); //armazenar nova reserva
Route::get('/reservas/del/{id}/{id_user}', 'ReservasC@destroy')->middleware('auth:web,admin')->name('reservas_del'); //deletar reserva

//rotas para regras:

Route::get('/regras', 'RegrasC@index')->middleware('auth:web,admin')->name('regras'); //pagina de regras (modificado para os tipos de usuarios)
Route::post('/regras', 'RegrasC@store')->middleware('auth:admin')->name('regras_criar'); //armazenar nova regra
Route::get('/regras/del/{id}', 'RegrasC@destroy')->middleware('auth:admin')->name('regras_del'); //deletar regra
Route::post('/regras/edit/{id}', 'RegrasC@update')->middleware('auth:admin')->name('regras_edit'); //atualizar regra

//rotas para ajuda:

Route::get('/ajuda', 'PerguntasC@index')->middleware('auth:web,admin')->name('ajuda'); //pagina de perguntas (modificado para os tipos de usuarios)
Route::post('/ajuda', 'PerguntasC@store')->middleware('auth:admin')->name('pergunta_criar'); //armazenar nova pergunta
Route::get('/ajuda/del/{id}', 'PerguntasC@destroy')->middleware('auth:admin')->name('pergunta_del'); //deletar pergunta
Route::post('/ajuda/edit/{id}', 'PerguntasC@update')->middleware('auth:admin')->name('pergunta_edit'); //atualizar pergunta
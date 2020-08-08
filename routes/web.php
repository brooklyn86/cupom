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
    return redirect()->route('login');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {
	Route::get('/home', 'CupomController@index')->name('home');
	Route::get('/criar/produto', ['as' => 'product.create', 'uses' => 'ProductController@create']);
	Route::get('/listar/produto', ['as' => 'product.list', 'uses' => 'ProductController@index']);
	Route::get('/editar/produto', ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
	Route::post('/editar/produto', ['as' => 'product.edit.post', 'uses' => 'ProductController@update']);
	Route::get('/listar/notas', ['as' => 'notas.list', 'uses' => 'CupomController@index']);
	Route::get('/criar/nova-notas', ['as' => 'create.nota', 'uses' => 'CupomController@create']);
	Route::get('/returnProductList', ['as' => 'product.listDatatable', 'uses' => 'ProductController@returnProductList']);
	Route::get('/returnNotaList', ['as' => 'product.notaLista', 'uses' => 'CupomController@returnList']);
	Route::get('/autocomplete/product', ['as' => 'product.listDatatable', 'uses' => 'ProductController@autocompleteproduct']);
	Route::post('/create/nota', ['as' => 'create.nota.post', 'uses' => 'CupomController@store']);
	Route::get('/imprimir/nota', ['as' => 'imprimir.post', 'uses' => 'CupomController@imprimir']);
	Route::post('/create/product', ['as' => 'create.product', 'uses' => 'ProductController@store']);
	
});
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
/*
|--------------------------------------------
| Rutas para Gestion de Sistema
|--------------------------------------------
*/



Auth::routes();

Route::resources([
	'manager'	 	=> 'ManagerController',
	'operador'		=> 'OperadoresController',
	'perfil'		=> 'PerfilController'
	]);

Route::get('check_disk','ManagerController@checkDisk');
Route::post('/search', 'QueryController@byTime');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register', 'HomeController@register')->name('register');
Route::post('/register', 'ManagerController@user_register');
Route::get('donwload/{id}', 'ManagerController@donwload')->name('donwload');
//Route::view('/home', 'admin.admin');

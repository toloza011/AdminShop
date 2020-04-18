<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/',function(){
    return view('welcome');
});
Auth::routes();

Route::resource('Productos', 'ProductoController');
Route::post('Productos/store','ProductoController@store')->name('Productos.store');
Route::post('Productos/update', 'ProductoController@update')->name('Productos.update');
Route::get('Productos/destroy/{id}', 'ProductoController@destroy');

Route::resource('Usuarios', 'UserController');
Route::post('Usuarios/store','UserController@store')->name('Usuarios.store');
Route::post('Usuarios/update','UserController@update')->name('Usuarios.update');
Route::get('Usuarios/destroy/{id}','UserController@destroy');


Route::resource('Categorias', 'CategoriaController');
Route::post('Categorias/store','CategoriaController@store')->name('Categorias.store');
Route::post('Categorias/update','CategoriaController@update')->name('Categorias.update');
Route::get('Categorias/destroy/{id}','CategoriaController@destroy');

Route::resource('Pedidos','PedidoController');
Route::post('Pedidos/store','PedidoController@store')->name('Pedidos.store');
Route::post('Pedidos/update','PedidoController@update')->name('Pedidos.update');
Route::get('Pedidos/destroy/{id}','PedidoController@destroy');


Route::get('Tienda',function(){
   return view('Tienda.index');
});
Route::get('Tienda/cart',function(){
    return view('Tienda.cart');
 });


Route::get('/home', 'HomeController@home')->name('home');

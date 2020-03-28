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

Route::get('/home', 'HomeController@index')->name('home');

//DAYSALE
Route::post('/createDaySale', 'DaySaleController@create');

//SALE
Route::post('/createSale', 'SaleController@create');
Route::put('updatePayment','SaleController@updatePayment');
//FRUIT
Route::post('/createFruit', 'FruitController@create');
Route::post('/updateFruit','FruitController@update');

//Customer
Route::post('/createCustomer', 'CustomerController@create');
Route::post('/updateCustomer', 'CustomerController@update');

//Seller
Route::post('/createSeller','SellerController@create');
Route::post('/updateSeller','SellerController@update');

//Cellar
Route::post('/createCellar','CellarController@create');
Route::post('/updateCellar','CellarController@update');
//Store
Route::get('/stores', 'StoreController@index')->name('Tiendas');
Route::get('/editStore', 'StoreController@edit');
Route::post('/createStore', 'StoreController@create');
Route::post('/updateStore', 'StoreController@update');

//Main store
Route::get('/storesMenu', 'StoresMenuController@index')->name('Menu Tiendas');

//Store detail
Route::get('/store/{id}/', 'StoreDetailController@index')->name('Tienda');
Route::get('editFruit', 'StoreDetailController@editFruit');
Route::get('editCellar', 'StoreDetailController@editCellar');
Route::get('getSales', 'StoreDetailController@getSales');
Route ::get('editSale', 'StoreDetailController@editSale');
Route ::get('editCustomer', 'StoreDetailController@editCustomer');
Route ::get('editSeller', 'StoreDetailController@editSeller');
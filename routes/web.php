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

/*Route::get('/', function () {
    return view('welcome');
}); */


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::get('/sach','App\Http\Controllers\LayoutController@sach');
Route::get('/','App\Http\Controllers\LayoutController@sach');
Route::get('/sach/theloai/{d}','App\Http\Controllers\LayoutController@theloai');
Route::get('detail_sach/{id}','App\Http\Controllers\LayoutController@chitiet');
Route::get('/accountpanel','App\Http\Controllers\AccountController@accountpanel')->middleware('auth')->name("account");
Route::post('/saveaccountinfo','App\Http\Controllers\AccountController@saveaccountinfo')->middleware('auth')->name('saveinfo');
Route::get('/book/list','App\Http\Controllers\LayoutController@booklist')->middleware('auth')->name('booklist');
Route::get('/book/create','App\Http\Controllers\LayoutController@bookcreate')->middleware('auth')->name('bookcreate');
Route::get('/book/edit/{id}','App\Http\Controllers\LayoutController@bookedit')->middleware('auth')->name('bookedit');
Route::post('/book/delete','App\Http\Controllers\LayoutController@bookdelete')->middleware('auth')->name('bookdelete');
Route::post('/book/save/{action}','App\Http\Controllers\LayoutController@booksave')->middleware('auth')->name('booksave');
Route::get('/order','App\Http\Controllers\BookController@order')->name('order');
Route::post('/cart/add','App\Http\Controllers\BookController@cartadd')->name('cartadd');
 Route::post('/cart/delete','App\Http\Controllers\BookController@cartdelete')->name('cartdelete');
 Route::post('/order/create','App\Http\Controllers\BookController@ordercreate') ->middleware('auth')->name('ordercreate');
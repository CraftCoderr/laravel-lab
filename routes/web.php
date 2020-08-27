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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/admin', 'BlogController@admin')->name('admin');
Route::post('/admin/post', 'BlogController@post')->name('publish-post');
Route::get('/admin/post/{post}/delete', 'BlogController@delete')->name('delete-post');

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
Route::post('/admin/post', 'BlogController@publish')->name('publish-post');
Route::post('/admin/import', 'BlogController@import')->name('import-posts');
Route::get('/admin/post/{post}/delete', 'BlogController@delete')->name('delete-post');
Route::get('/admin/post/{post}/edit', 'BlogController@edit')->name('edit-post');
Route::post('/admin/post/{post}', 'BlogController@update')->name('update-post');

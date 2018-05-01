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

Route::get('/image-view','ImageController@index')->name('image.index');
Route::post('/image-view','ImageController@store')->name('image.store');

Route::get('/image-crop','ImageController@imageCrop')->name('imageCrop');
Route::post('/image-crop','ImageController@imageCropPost')->name('imageCropPost');

Route::get('/image-upload','ImageController@imageUpload');
Route::post('/image-upload','ImageController@imageUploadPost');

Route::get('/dropzone','ImageController@dropzone');
Route::post('/dropzone/store',['as'=>'dropzone.store','uses'=>'ImageController@dropzoneStore']);

Route::get('/resizeImage','ImageController@resizeImage');
Route::post('/resizeImagePost',['as'=>'resizeImagePost','uses'=>'ImageController@resizeImagePost']);




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

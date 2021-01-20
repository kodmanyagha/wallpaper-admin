<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Api\ImageController@index');
Route::get('/random', 'Api\ImageController@random');
Route::get('/image/{id}', 'Api\ImageController@image');
Route::get('/category/{slug}', 'Api\ImageController@category');
Route::get('/categories', 'Api\ImageController@categories');


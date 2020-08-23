<?php
// use Illuminate\Support\Facades\Route;

// Auth::routes();

Route::middleware('auth')->group(function(){
  Route::get('/posts', 'PostController@index');

});

Route::get('{any}', 'AppController@index')
->where('any','.*')
->middleware('auth')
->name('home');

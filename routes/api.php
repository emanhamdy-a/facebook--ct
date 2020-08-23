<?php

use Illuminate\Http\Request;
// Auth::routes();
Route::middleware('auth:api')->group(function(){
  Route::get('/user', function (Request $request) {
    return $request->user();
});
  // Route::post('/postat', 'PostController@index');
  Route::post('/posts', 'PostController@store');
  Route::get('/posts', 'PostController@index');
});


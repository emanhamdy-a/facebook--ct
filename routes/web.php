<?php
// use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')->group(function(){
  Route::prefix('wb')->group(function () {
    Route::get('auth-user', 'AuthUserController@show');
    Route::post('/friendShip' , 'FriendRequestController@delete');
    Route::Resources([
      '/posts' => 'PostController',
      '/posts/{post}/like' => 'PostLikeController',
      '/posts/{post}/comment' => 'PostCommentController',
      '/users' => 'UserController',
      '/users/{user}/posts' => 'UserPostController',
      '/friend-request' => 'FriendRequestController',
      '/friend-request-response' => 'FriendRequestResponseController',
      '/user-images' => 'UserImageController',
    ]);
  });

  Route::get('{any}', 'AppController@index')
  ->where('any','.*')
  ->middleware('auth')
  ->name('home');
});





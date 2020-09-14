<?php
// Auth::routes();
Route::post('/register','api\AuthController@register');
Route::post('/login','api\AuthController@login');

Route::middleware('auth:api')->group(function () {

  Route::get('auth-user', 'AuthUserController@show');

  Route::apiResources([
    '/posts' => 'PostController',
    '/posts/{post}/like' => 'PostLikeController',
    '/posts/{post}/comment' => 'PostCommentController',
    '/users' => 'UserController',
    '/users/{user}/posts' => 'UserPostController',
    '/friend-request' => 'FriendRequestController',
    '/friendShip' => 'FriendRequestController',
    '/friend-request-response' => 'FriendRequestResponseController',
    '/user-images' => 'UserImageController',
  ]);

});



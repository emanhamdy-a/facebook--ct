<?php

namespace App;

use App\Post;
// changeapi

use App\UserImage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  //
  use HasApiTokens, Notifiable;

  protected $fillable = [
      'name', 'email', 'password',
  ];

  protected $hidden = [
      'password', 'remember_token',
  ];

  protected $casts = [
      'email_verified_at' => 'datetime',
  ];
  public function coverImage()
  {
    return $this->hasOne(UserImage::class)
    ->orderByDesc('id')
    ->where('location','cover')
    ->withDefault(function($userImage){
      $userImage->path='user-images/1.jpeg';
    });
  }
  public function profileImage()
  {
    return $this->hasOne(UserImage::class)
    ->orderByDesc('id')
    ->where('location','profile')
    ->withDefault(function($userImage){
      $userImage->path='user-images/person1.png';
    });
  }
  public function images()
  {
    return $this->hasMany(UserImage::class);
  }
  public function posts(){
    return $this->hasMany(Post::class);
  }
  public function friends(){
    return $this->belongsToMany(User::class,'friends','friend_id','user_id');
  }
  public function likedPosts(){
    return $this->belongsToMany(Post::class,'likes','user_id','post_id');
  }
}

<?php

namespace App;

use App\User;
use App\Friend;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
  protected $guarded = [];

  protected $dates = ['confirmed_at'];

  public static function friendship($userId)
  {
    return (new static())
      ->where(function ($query) use ($userId) {
        return $query->where('user_id', auth()->user()->id)
          ->where('friend_id', $userId);
      })
      ->orWhere(function ($query) use ($userId) {
        return $query->where('friend_id', auth()->user()->id)
          ->where('user_id', $userId);
      })
      ->first();
  }

  public static function friendships()
  {
    return (new static())
      ->whereNotNull('confirmed_at')
      ->where(function ($query) {
        return $query->where('user_id', auth()->user()->id)
          ->orWhere('friend_id', auth()->user()->id);
      })
      ->get();
  }
  public static function friendequests()
  {
    return (new static())
      ->whereNull('confirmed_at')
      ->where(function ($query) {
        return $query->where('user_id', auth()->user()->id)
          ->orWhere('friend_id', auth()->user()->id);
          // ->with('friend_id')->select('users.*')
      })
      ->get();
  }

  public function friend_info($friendId)
  {
    $nm_img = User::join('user_images', 'users.id', '=', 'user_images.user_id')
    ->select('users.id AS friend_id','users.name','user_images.path AS image'
      ,'user_images.width AS image_width'
      ,'user_images.height  AS image_height')
    ->where('user_images.location','profile')
    ->where('users.id',$friendId)
    ->first();
    return $nm_img ? $nm_img : User::where('id',$friendId)
    ->select('id AS friend_id','name')
    ->first();
  }
}

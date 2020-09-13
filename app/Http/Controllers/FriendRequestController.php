<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationErrorException;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Friend as FriendResource;
use App\Exceptions\FriendRequestNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestController extends Controller
{

  public function store()
  {
    $data = request()->validate([
      'friend_id' => 'required',
    ]);

    try {
      User::findOrFail($data['friend_id'])
      ->friends()->syncWithoutDetaching(auth()->user());
    } catch (ModelNotFoundException $e) {
      throw new UserNotFoundException();
    }
    return new FriendResource(
      Friend::where('user_id', auth()->user()->id)
      ->where('friend_id', $data['friend_id'])
      ->first()
    );
  }
  //user can delete friend request or friendship
  public function delete(){
    $data = request()->validate([
      'user_id' => '',
      ]);
    try {
      Friend::where('user_id',auth()->user()->id )
        ->where('friend_id', $data['user_id'])
        ->orwhere('user_id',$data['user_id'])
        ->where('friend_id',auth()->user()->id)
        ->firstOrFail()
        ->delete();
    } catch (ModelNotFoundException $e) {
      throw new FriendRequestNotFoundException();
    }
    return null;
  }
}

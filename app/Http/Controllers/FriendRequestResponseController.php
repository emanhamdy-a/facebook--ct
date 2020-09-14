<?php

namespace App\Http\Controllers;

use App\Friend;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Friend as FriendResource;
use App\Exceptions\FriendRequestNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestResponseController extends Controller
{
  public function update()
  {
    return '$friend_id';

    $data = request()->validate([
      'friend_id' => 'required',
      // 'status' => 'required',
    ]);

    try {
      $friendRequest = Friend::where('user_id', $data['friend_id'])
      ->where('friend_id', auth()->user()->id)
      ->firstOrFail();
    } catch (ModelNotFoundException $e) {
      throw new FriendRequestNotFoundException();
    }
    // $friendRequest->update(array_merge($data,['confirmed_at' => now()]));
    $friendRequest->confirmed_at=now();
    $friendRequest->status=1;
    $friendRequest->save();
    return new FriendResource($friendRequest);
  }

  public function AcceptFriendRequest($friend_id)
  {
    // return $friend_id;
    try {
      $friendRequest = Friend::where('user_id', $friend_id)
      ->where('friend_id', auth()->user()->id)
      ->first();
    } catch (ModelNotFoundException $e) {
      throw new FriendRequestNotFoundException();
    }
    // $friendRequest->update(array_merge($data,['confirmed_at' => now()]));
    $friendRequest->confirmed_at=now();
    $friendRequest->status=1;
    $friendRequest->save();
    return new FriendResource($friendRequest);
  }

  //delete friend request or friendship
  public function destroy($userId)
  {
    if($userId){
      try {
        Friend::where('user_id',auth()->user()->id)
          ->where('friend_id', $userId )
          ->orwhere('user_id',$userId)
          ->where('friend_id',auth()->user()->id)
          ->firstOrFail()
          ->delete();
      } catch (ModelNotFoundException $e) {
        throw new FriendRequestNotFoundException();
      }
    }
    return null;
  }
}

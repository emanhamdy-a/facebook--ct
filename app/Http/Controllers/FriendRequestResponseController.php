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
  public function store()
  {
    $data = request()->validate([
      'user_id' => 'required',
      'status' => 'required',
    ]);

    try {
      $friendRequest = Friend::where('user_id', $data['user_id'])
      ->where('friend_id', auth()->user()->id)
      ->firstOrFail();
    } catch (ModelNotFoundException $e) {
      throw new FriendRequestNotFoundException();
    }

    $friendRequest->update(array_merge($data,['confirmed_at' => now()]));

    // $friendRequest->confirmed_at=now();
    // $friendRequest->status=1;
    // $friendRequest->save();
    return new FriendResource($friendRequest);
  }

  //friend can delete friend request or friendship
  public function destroy()
  {
    $data = request()->validate([
      'user_id' => 'required',
    ]);

    try {
      Friend::where('user_id', $data['user_id'])
        ->where('friend_id', auth()->user()->id)
        ->firstOrFail()
        ->delete();
    } catch (ModelNotFoundException $e) {
      throw new FriendRequestNotFoundException();
    }

    return response()->json([], 204);
  }
}

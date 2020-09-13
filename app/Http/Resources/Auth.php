<?php

namespace App\Http\Resources;

use App\Friend;
use App\Http\Resources\FriendCollection;
use App\Http\Resources\Friend as FriendResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserImage as UserImageResource;

class Auth extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      // dd($this->id);
      return [
        'data'=>[
          'type'=>'users',
          'user_id'=>$this->id,
          'attributes'=>[
            'name' => $this->name,
            'friendship'=>new FriendResource(Friend::friendship($this->id)),
            'friendships'=>new FriendCollection(Friend::friendships()),
            'friendequests'=>new FriendCollection(Friend::friendequests()),
            'cover_image'=>new UserImageResource($this->coverImage),
            'profile_image'=>new UserImageResource($this->profileImage),
          ]
        ],
        'links' => [
          'self' => url("/users/" . $this->id),
        ]
      ];
    }
}

<?php

namespace App\Http\Resources;
use App\User;
use App\Friend as FriendModel;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Friend extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $friendId=auth()->user()->id == $this->user_id ? $this->friend_id : $this->user_id;
      return [
        'data' => [
            'type' => 'friend-request',
            'friend_request_id' => $this->id,
            'attributes' => [
              'confirmed_at' => optional($this->confirmed_at)->diffForHumans(),
              'friend_id' => $this->friend_id,
              'user_id' => $this->user_id,
              'friend_info'=>$this->friend_info($friendId),
            ]
        ],
        'links' => [
            'self' => url('/users/'.$this->friend_id),
        ]
      ];
    }
}

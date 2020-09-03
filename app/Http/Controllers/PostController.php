<?php

namespace App\Http\Controllers;

use App\Post;
use App\Friend;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {
      $friends=Friend::friendships();

      if($friends->isEmpty()){
        return new PostCollection(request()->user()->posts);
      }
      return new PostCollection(
        Post::whereIn('user_id',[$friends->pluck('user_id'),$friends->pluck('friend_id')])->get()
      );
      // return request()->user()->posts;
    }

    public function store()
    {
      $data=request()->validate([
        'body'=>'',
        // 'data.attributes.body'=>'',
      ]);
      $post=request()->user()->posts()->create($data);
      // $post=request()->user()->posts()->create($data['data']['attributes']);
      return new PostResource($post);
      // return response([], 201);
    }
}

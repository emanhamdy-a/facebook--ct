<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Resources\CommentCollection;

class PostCommentController extends Controller
{
  public function store(Post $post)
  {
    $data = request()->validate([
        'body' => 'required',
    ]);

    $post->comments()->create(array_merge($data, [
        'user_id' => auth()->user()->id,
    ]));

    // Comment::create([
    //     'user_id' => auth()->user()->id,
    //     'post_id' => $post->id,
    //     'body' => $data['body'],
    // ]);

    return new CommentCollection($post->comments);
  }
}

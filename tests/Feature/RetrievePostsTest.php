<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use App\Friend;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RetrievePostsTest extends TestCase
{
  use DatabaseTransactions;
  // use RefreshDatabase;
  /** @test */
  public function a_user_can_retrieve_posts()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user=factory(User::class)->create(),'api');
    $posts=factory(Post::class,2)->create(['user_id'=>$user->id]);
    $response=$this->get('/api/posts');
    // $response=$this->post('/api/postat');
    $response->assertStatus(200)
    ->assertJson([
      'data'=>[
        [
          'data'=>[
            'type'=>'posts',
            'post_id'=>$posts->last()->id,
            'attributes'=>[
              'body'=>$posts->last()->body,
              'image'=>$posts->last()->image,
              'posted_at'=>$posts->last()->created_at->diffForHumans(),
            ]
          ]
        ],
        [
          'data'=>[
            'type'=>'posts',
            'post_id'=>$posts->first()->id,
            'attributes'=>[
              'body'=>$posts->first()->body,
              'image'=>$posts->first()->image,
              'posted_at'=>$posts->first()->created_at->diffForHumans(),
            ]
          ]
        ]
      ],
      'links'=>[
        'self'=>url('/posts'),
      ]

    ]);
  }

  /** @test */
  public function a_user_can_only_retrieve_their_posts()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser=factory(\App\User::class)->create();
    $posts = factory(\App\Post::class)->create(['user_id'=>$anotherUser->id]);
    Friend::create([
      'user_id'=>$user->id,
      'friend_id'=>$anotherUser->id,
      'confirmed_at'=>now(),
      'status'=>1,
    ]);
    $response = $this->get('/api/posts');
    $response->assertStatus(200)
      ->assertJson([
          'data' => [],
          'links' => [
              'self' => url('/posts'),
          ]
      ]);
  }
}
// vendor\bin\phpunit Tests\Feature\\
// vendor\bin\phpunit --filter RetrievePostsTest
// vendor\bin\phpunit --filter a_user_can_retrieve_posts
// vendor\bin\phpunit --filter a_user_can_only_retrieve_their_posts

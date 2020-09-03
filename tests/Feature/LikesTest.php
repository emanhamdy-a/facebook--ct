<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
  use DatabaseTransactions;
  // use RefreshDatabase;

  /** @test */
  public function a_user_can_like_a_post()
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123]);

    $response = $this->post('/api/posts/'.$post->id.'/like')
        ->assertStatus(200);

    $this->assertCount(1, $user->likedPosts);
    $response->assertJson([
      'data' => [
        [
          'data' => [
            'type' => 'likes',
            'like_id' =>$post->likes[0]->id,
            'attributes' => []
          ],
          'links' => [
            'self' => url('/posts/123'),
          ]
        ]
      ],
      'links' => [
        'self' => url('/posts'),
      ]
    ]);
  }

  /** @test */
  public function posts_are_returned_with_likes()
  {
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);
    $this->post('/api/posts/'.$post->id.'/like')
        ->assertStatus(200);

    $response = $this->get('/api/posts')
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'attributes' => [
                'likes' => [
                  'data' => [
                    [
                      'data' => [
                        'type' => 'likes',
                        'like_id' => $post->likes[0]->id,
                        'attributes' => []
                      ]
                    ]
                  ],
                'like_count' => 1,
                'user_likes_post' => true,
                ],
              ]
            ]
          ]
        ]
      ]);

  }
}
// vendor\bin\phpunit --filter posts_are_returned_with_likes
// vendor\bin\phpunit --filter a_user_can_like_a_post

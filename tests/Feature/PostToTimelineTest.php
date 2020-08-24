<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostToTimelineTest extends TestCase
{
  use DatabaseTransactions;
  // use RefreshDatabase;
  /** @test */
  public function a_user_can_post_a_text_post()
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user=factory(User::class)->create(),'api');
    $response=$this->post('/api/posts',[
      'data' => [
        'type' => 'posts',
        'attributes' => [
          'body' => 'Testing Body',
        ]
      ],
    ]);

    $post=Post::first();
    // $this->assertCount(1, Post::all());

    $this->assertCount(1, Post::all());
    $this->assertEquals($user->id, $post->user_id);
    $this->assertEquals('Testing Body', $post->body);
    $response->assertStatus(201)->assertJson([
      'data'=>[
        'type'=>'posts',
        'post_id'=>$post->id,
        'attributes'=>[
          'posted_by'=> [
            'data'=>[
              'attributes'=>[
                'name'=>$user->name,
              ]
            ]
          ],
          'body' => 'Testing Body',
        ]
        ],
        'links' => [
          'self' => url("/posts/" . $post->id),
        ]
    ]);
  }
}
// in phpunit.xml
// <server name='DB_CONNECTION' value='myspl'/>
// <server name='DB_DATABASE' value='faceboo_ct'/>

// in terminal

// vendor\bin\phpunit --filter a_user_can_post_a_text_post\\
// phpunit Tests\Feature\PostToTimelineTest.php
// vendor\bin\phpunit Tests\Feature\\

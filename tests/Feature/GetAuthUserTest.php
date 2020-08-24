<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class GetAuthUserTest extends TestCase
{
  // use RefreshDatabase;
  use DatabaseTransactions;

  /** @test */
  public function authenticated_user_can_be_fetched()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(User::class)->create(), 'api');

    $response = $this->get('/api/auth-user');

    $response->assertStatus(200)
    ->assertJson([
      'data' => [
        'user_id' => $user->id,
        'attributes' => [
          'name' => $user->name,
        ]
      ],
      'links' => [
          'self' => url('/users/'.$user->id),
      ]
    ]);
  }
}
// vendor\bin\phpunit --filter authenticated_user_can_be_fetched\\
// vendor\bin\phpunit Tests\Feature\\


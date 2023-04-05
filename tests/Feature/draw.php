<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Draw

class draw extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testsDrawCorrectly()
    {
        $user = factory(User::class)->create();
        factory(Draw::class)->create([
            'name' => 'First draw',
            'user_id' => $user->id
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/draws', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'name' => 'First Draw', 'user_id' => $user->id ],
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'user_id', 'created_at', 'updated_at'],
            ]);
    }

}

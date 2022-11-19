<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        User::factory()->create(['name' => 'John']);
        User::factory()->count(2)->create();

        $response = $this->get('/api/users');

        $this->assertDatabaseHas('users', ['name' => 'John']);
        $this->assertDatabaseCount('users', 3);
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $user = [
            'id' => 1,
            'name' => 'John'
        ];

        $response = $this->post('/api/users', $user);

        $this->assertDatabaseCount('users', 1);
        $response->assertStatus(200);
        $this->assertEquals($user['id'], $response->getData()->user->id);
        $this->assertEquals($user['name'], $response->getData()->user->name);
    }

    public function testShow(): void
    {
        $userIds = [1,2,3];

        foreach ($userIds as $userId) {
            User::factory()->create([
                'id' => $userId,
                'name' => "John_{$userId}"
            ]);
        }

        $id = 1;
        $response = $this->get("/api/users/{$id}");

        $this->assertDatabaseCount('users', 3);
        $response->assertStatus(200);
        $this->assertEquals($id, $response->getData()->user->id);
        $this->assertEquals("John_{$id}", $response->getData()->user->name);
    }

    public function testUpdate(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => "John_1"
        ]);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['id' => 1, 'name' => 'John_1']);

        $response = $this->put('/api/users/1', ['name' => 'John_2']);

        $this->assertDatabaseCount('users', 1);
        $response->assertStatus(200);
        $this->assertEquals(1, $response->getData()->user->id);
        $this->assertEquals('John_2', $response->getData()->user->name);
    }

    public function testDestroy(): void
    {
        User::factory()->count(3)->create();

        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseHas('users', ['id' => 1]);

        $this->delete('/api/users/1');

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseMissing('users', ['id' => 1]);
    }
}

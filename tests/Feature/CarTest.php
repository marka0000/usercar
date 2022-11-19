<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        Car::factory()->create(['name' => 'Auto']);
        Car::factory()->count(2)->create();

        $response = $this->get('/api/cars');

        $this->assertDatabaseHas('cars', ['name' => 'Auto']);
        $this->assertDatabaseCount('cars', 3);
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        User::factory()->create(['name' => 'John']);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['id' => 1, 'name' => 'John']);

        $car = [
            'id' => 1,
            'name' => 'Auto',
            'userId' => 1,
        ];

        $response = $this->post('/api/cars', $car);

        $this->assertDatabaseCount('cars', 1);
        $response->assertStatus(200);
        $this->assertEquals($car['id'], $response->getData()->car->id);
        $this->assertEquals($car['name'], $response->getData()->car->name);
        $this->assertEquals('John', $response->getData()->car->user->name);
    }

    public function testShow(): void
    {
        $carIds = [1,2,3];

        foreach ($carIds as $carId) {
            Car::factory()->create([
                'id' => $carId,
                'name' => "Auto_{$carId}"
            ]);
        }

        $id = 1;
        $response = $this->get("/api/cars/{$id}");

        $this->assertDatabaseCount('cars', 3);
        $response->assertStatus(200);
        $this->assertEquals($id, $response->getData()->car->id);
        $this->assertEquals("Auto_{$id}", $response->getData()->car->name);
    }

    public function testUpdate(): void
    {
        Car::factory()->create([
            'id' => 1,
            'name' => "Auto_1"
        ]);

        $this->assertDatabaseCount('cars', 1);
        $this->assertDatabaseHas('cars', ['id' => 1, 'name' => 'Auto_1']);

        $response = $this->put('/api/cars/1', ['name' => 'Auto_2']);

        $this->assertDatabaseCount('cars', 1);
        $response->assertStatus(200);
        $this->assertEquals(1, $response->getData()->car->id);
        $this->assertEquals('Auto_2', $response->getData()->car->name);
    }

    public function testDestroy(): void
    {
        Car::factory()->count(3)->create();

        $this->assertDatabaseCount('cars', 3);
        $this->assertDatabaseHas('cars', ['id' => 1]);

        $this->delete('/api/cars/1');

        $this->assertDatabaseCount('cars', 2);
        $this->assertDatabaseMissing('cars', ['id' => 1]);
    }
}

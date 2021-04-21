<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_status_can_create()
    {
        $this->authenticate();

        $createdStatus = Status::factory()->make();
        $response = $this->post('/api/v1/statuses', $createdStatus->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('statuses', $createdStatus->toArray());
    }

    public function test_status_can_not_create_without_authorization()
    {
        $createdStatus = Status::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/statuses', $createdStatus->toArray());
        $response->assertStatus(401);
    }

    public function test_status_can_delete()
    {
        $this->authenticate();

        $createdStatus = Status::factory()->create();
        $response = $this->delete('/api/v1/statuses/'. $createdStatus->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('statuses', $createdStatus->toArray());
    }

    public function test_status_can_not_delete_without_authorization()
    {
        $createdStatus = Status::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/statuses/'. $createdStatus->id);
        $response->assertStatus(401);
    }

    public function test_status_can_update()
    {
        $this->authenticate();

        $createdStatusInDb = Status::factory()->create();
        $createdStatus = Status::factory()->make();
        $response = $this->patch('/api/v1/statuses/'. $createdStatusInDb->id, $createdStatus->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('statuses', $createdStatus->toArray());
    }

    public function test_status_can_not_update_without_authorization()
    {
        $createdStatusInDb = Status::factory()->create();
        $createdStatus = Status::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/statuses/'. $createdStatusInDb->id, $createdStatus->toArray());
        $response->assertStatus(401);
    }

    public function test_status_can_show()
    {
        $this->authenticate();

        $createdStatus = Status::factory()->create();
        $response = $this->get('/api/v1/statuses/'. $createdStatus->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('statuses', $createdStatus->toArray());
    }

    public function test_status_can_not_show_without_authorization()
    {
        $createdStatus = Status::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/statuses/'. $createdStatus->id);
        $response->assertStatus(401);
    }

    public function test_status_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/statuses');
        $response->assertStatus(200);
    }

    public function test_status_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/clients?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_status_can_not_show_status_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/statuses/'. 0);
        $response->assertStatus(404);
    }

    public function test_status_can_not_update_status_with_invalid_id()
    {
        $this->authenticate();

        $createdClient = Status::factory()->make();
        $response = $this->patch('/api/v1/statuses/'. 0, $createdClient->toArray());
        $response->assertStatus(404);
    }

    public function test_status_can_not_delete_status_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/statuses/'. 0);
        $response->assertStatus(404);
    }
}

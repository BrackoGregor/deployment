<?php

namespace Tests\Feature;


use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\Client;

class ClientTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_client_can_create()
    {
        $this->authenticate();

        $createdClient = Client::factory()->make();
        $response = $this->post('/api/v1/clients', $createdClient->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $createdClient->toArray());
    }

    public function test_client_can_not_create_without_authorization()
    {
        $createdClient = Client::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/clients', $createdClient->toArray());
        $response->assertStatus(401);
    }

    public function test_client_can_delete()
    {
        $this->authenticate();

        $createdClient = Client::factory()->create();
        $response = $this->delete('/api/v1/clients/'. $createdClient->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('clients', $createdClient->toArray());
    }

    public function test_client_can_not_delete_without_authorization()
    {
        $createdClient = Client::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/clients/'. $createdClient->id);
        $response->assertStatus(401);
    }

    public function test_client_can_update()
    {
        $this->authenticate();

        $createdClientInDb = Client::factory()->create();
        $createdClient = Client::factory()->make();
        $response = $this->patch('/api/v1/clients/'. $createdClientInDb->id, $createdClient->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $createdClient->toArray());
    }

    public function test_client_can_not_update_without_authorization()
    {
        $createdClientInDb = Client::factory()->create();
        $createdClient = Client::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/clients/'. $createdClientInDb->id, $createdClient->toArray());
        $response->assertStatus(401);
    }

    public function test_client_can_show()
    {
        $this->authenticate();

        $createdClientInDb = Client::factory()->create();
        $response = $this->get('/api/v1/clients/'. $createdClientInDb->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $createdClientInDb->toArray());
    }

    public function test_client_can_not_show_without_authorization()
    {
        $createdClientInDb = Client::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/clients/'. $createdClientInDb->id);
        $response->assertStatus(401);
    }

    public function test_client_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/clients');
        $response->assertStatus(200);
    }

    public function test_client_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/clients?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_client_can_not_show_client_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/clients/'. 0);
        $response->assertStatus(404);
    }

    public function test_client_can_not_update_client_with_invalid_id()
    {
        $this->authenticate();

        $createdClient = Client::factory()->make();
        $response = $this->patch('/api/v1/clients/'. 0, $createdClient->toArray());
        $response->assertStatus(404);
    }

    public function test_client_can_not_delete_client_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/clients/'. 0);
        $response->assertStatus(404);
    }
}

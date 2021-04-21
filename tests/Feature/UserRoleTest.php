<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User_Role;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_status_can_create()
    {
        $this->authenticate();

        $createdRole = User_Role::factory()->make();
        $response = $this->post('/api/v1/roles', $createdRole->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('users_roles', $createdRole->toArray());
    }

    public function test_status_can_not_create_without_authorization()
    {
        $createdRole = User_Role::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/roles', $createdRole->toArray());
        $response->assertStatus(401);
    }

    public function test_status_can_delete()
    {
        $this->authenticate();

        $createdRole = User_Role::factory()->create();
        $response = $this->delete('/api/v1/roles/'. $createdRole->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('users_roles', $createdRole->toArray());
    }

    public function test_status_can_not_delete_without_authorization()
    {
        $createdRole = User_Role::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/roles/'. $createdRole->id);
        $response->assertStatus(401);
    }

    public function test_status_can_update()
    {
        $this->authenticate();

        $createdRoleInDb = User_Role::factory()->create();
        $createdRole = User_Role::factory()->make();
        $response = $this->patch('/api/v1/roles/'. $createdRoleInDb->id, $createdRole->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('users_roles', $createdRole->toArray());
    }

    public function test_status_can_not_update_without_authorization()
    {
        $createdRoleInDb = User_Role::factory()->create();
        $createdRole = User_Role::factory()->make();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/roles/'. $createdRoleInDb->id, $createdRole->toArray());
        $response->assertStatus(401);
    }

    public function test_status_can_show()
    {
        $this->authenticate();

        $createdRole = User_Role::factory()->create();
        $response = $this->get('/api/v1/roles/'. $createdRole->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users_roles', $createdRole->toArray());
    }

    public function test_status_can_not_show_without_authorization()
    {
        $createdRole = User_Role::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/roles/'. $createdRole->id);
        $response->assertStatus(401);
    }

    public function test_status_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/roles');
        $response->assertStatus(200);
    }

    public function test_status_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/roles?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_status_can_not_show_status_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/roles/'. 0);
        $response->assertStatus(404);
    }

    public function test_status_can_not_update_status_with_invalid_id()
    {
        $this->authenticate();

        $createdRole = User_Role::factory()->make();
        $response = $this->patch('/api/v1/roles/'. 0, $createdRole->toArray());
        $response->assertStatus(404);
    }

    public function test_status_can_not_delete_status_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/roles/'. 0);
        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User_Role;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_user_can_create()
    {
        $this->authenticate();

        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->make(
            ['id_users_roles' => $createdUserRole->id]
        );

        $response = $this->post('/api/v1/users', $createdUser->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $createdUser->toArray());
    }

    public function test_user_can_not_create_without_authorization()
    {
        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->create(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/users', $createdUser->toArray());
        $response->assertStatus(401);
    }

    public function test_user_can_delete()
    {
        $this->authenticate();

        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->create(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->delete('/api/v1/users/'. $createdUser->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('users', $createdUser->toArray());
    }

    public function test_user_can_not_delete_without_authorization()
    {
        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->create(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/users/'. $createdUser->id);
        $response->assertStatus(401);
    }

    public function test_user_can_update()
    {
        $this->authenticate();

        $createdUserRoleInDb = User_Role::factory()->create();
        $createdUserInDb = User::factory()->create(
            ['id_users_roles' => $createdUserRoleInDb->id]
        );

        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->make(
            ['id_users_roles' => $createdUserRole->id]
        );

        $response = $this->patch('/api/v1/users/'. $createdUserInDb->id, $createdUser->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $createdUser->toArray());
    }

    public function test_user_can_not_update_without_authorization()
    {
        $createdUserRoleInDb = User_Role::factory()->create();
        $createdUserInDb = User::factory()->create(
            ['id_users_roles' => $createdUserRoleInDb->id]
        );

        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->make(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/users/'. $createdUserInDb->id, $createdUser->toArray());
        $response->assertStatus(401);
    }

    public function test_user_can_show()
    {
        $this->authenticate();

        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->create(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->get('/api/v1/users/'. $createdUser->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $createdUser->toArray());
    }

    public function test_user_can_not_show_without_authorization()
    {
        $createdUserRole = User_Role::factory()->create();
        $createdUser = User::factory()->create(
            ['id_users_roles' => $createdUserRole->id]
        );
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/users/'. $createdUser->id);
        $response->assertStatus(401);
    }

    public function test_client_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
    }

    public function test_user_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/users?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_user_can_not_show_user_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/users/'. 0);
        $response->assertStatus(404);
    }

    public function test_user_can_not_update_user_with_invalid_id()
    {
        $this->authenticate();

        $createdUser = User::factory()->create();
        $response = $this->patch('/api/v1/users/'. 0, $createdUser->toArray());
        $response->assertStatus(404);
    }

    public function test_user_can_not_delete_user_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/users/'. 0);
        $response->assertStatus(404);
    }
}

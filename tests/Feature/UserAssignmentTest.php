<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\User;
use App\Models\User_Assignment;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserAssignmentTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_user_assignment_can_create()
    {
        $this->authenticate();

        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->make(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->post('/api/v1/userAssignments', $createdUserAssignment->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('users_assignments', $createdUserAssignment->toArray());
    }

    public function test_user_assignment_can_not_create_without_authorization()
    {
        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/userAssignments', $createdUserAssignment->toArray());
        $response->assertStatus(401);
        $this->assertDatabaseHas('users_assignments', $createdUserAssignment->toArray());
    }

    public function test_user_assignment_can_delete()
    {
        $this->authenticate();

        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );
        $response = $this->delete('/api/v1/userAssignments/'. $createdUserAssignment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('users_assignments', $createdUserAssignment->toArray());
    }

    public function test_user_assignment_can_not_delete_without_authorization()
    {
        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/userAssignments/'. $createdUserAssignment->id);
        $response->assertStatus(401);
    }

    public function test_user_assignment_can_update()
    {
        $this->authenticate();

        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignmentInDb = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $createdUserInDb = User::factory()->create();
        $createdAssignmentInDb = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->make(
            ['id_users' => $createdUserInDb->id, 'id_assignments' => $createdAssignmentInDb->id]
        );

        $response = $this->patch('/api/v1/userAssignments/'. $createdUserAssignmentInDb->id, $createdUserAssignment->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('users_assignments', $createdUserAssignment->toArray());
    }

    public function test_user_assignment_can_not_update_without_authorization()
    {
        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignmentInDb = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $createdUserInDb = User::factory()->create();
        $createdAssignmentInDb = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->make(
            ['id_users' => $createdUserInDb->id, 'id_assignments' => $createdAssignmentInDb->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/userAssignments/'. $createdUserAssignmentInDb->id, $createdUserAssignment->toArray());
        $response->assertStatus(401);
    }

    public function test_user_assignment_can_get()
    {
        $this->authenticate();

        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->get('/api/v1/userAssignments/'. $createdUserAssignment->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users_assignments', $createdUserAssignment->toArray());
    }

    public function test_user_assignment_can_not_get_without_authorization()
    {
        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/userAssignments/'. $createdUserAssignment->id);
        $response->assertStatus(401);
    }

    public function test_user_assignment_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/userAssignments?page=1&per_page=3');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_user_assignment_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/userAssignments?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_user_assignment_can_not_show_user_assignment_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/userAssignments/'. 0);
        $response->assertStatus(404);
    }

    public function test_user_assignment_can_not_update_user_assignment_with_invalid_id()
    {
        $this->authenticate();;

        $createdUser = User::factory()->create();
        $createdAssignment = Assignment::factory()->create();
        $createdUserAssignment = User_Assignment::factory()->create(
            ['id_users' => $createdUser->id, 'id_assignments' => $createdAssignment->id]
        );

        $response = $this->patch('/api/v1/userAssignments/'. 0, $createdUserAssignment->toArray());
        $response->assertStatus(404);
    }

    public function test_user_assignments_can_not_delete_user_assignment_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/userAssignments/'. -0);
        $response->assertStatus(404);
    }
}

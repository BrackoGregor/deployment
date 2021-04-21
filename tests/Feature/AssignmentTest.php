<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Status;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_assignment_can_create()
    {
        $this->authenticate();

        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->post('/api/v1/assignments', $createdAssignment->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('assignments', $createdAssignment->toArray());
    }

    public function test_assignment_can_not_create_without_authorization()
    {
        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/assignments', $createdAssignment->toArray());
        $response->assertStatus(401);
        $this->assertDatabaseHas('assignments', $createdAssignment->toArray());
    }

    public function test_assignment_can_delete()
    {
        $this->authenticate();

        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );
        $response = $this->delete('/api/v1/assignments/'. $createdAssignment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('assignments', $createdAssignment->toArray());
    }

    public function test_assignment_can_not_delete_without_authorization()
    {
        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/assignments/'. $createdAssignment->id);
        $response->assertStatus(401);
    }

    public function test_assignment_can_update()
    {
        $this->authenticate();

        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignmentInDb = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $createdClientInDb = Client::factory()->create();
        $createdStatusInDb = Status::factory()->create();
        $createdAssignment = Assignment::factory()->make(
            ['id_clients' => $createdClientInDb->id, 'id_statuses' => $createdStatusInDb->id]
        );

        $response = $this->patch('/api/v1/assignments/'. $createdAssignmentInDb->id, $createdAssignment->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments', $createdAssignment->toArray());
    }

    public function test_assignment_can_not_update_without_authorization()
    {
        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignmentInDb = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $createdClientInDb = Client::factory()->create();
        $createdStatusInDb = Status::factory()->create();
        $createdAssignment = Assignment::factory()->make(
            ['id_clients' => $createdClientInDb->id, 'id_statuses' => $createdStatusInDb->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/assignments/'. $createdAssignmentInDb->id, $createdAssignment->toArray());
        $response->assertStatus(401);
    }

    public function test_assignment_can_get()
    {
        $this->authenticate();

        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->get('/api/v1/assignments/'. $createdAssignment->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments', $createdAssignment->toArray());
    }

    public function test_assignment_can_not_get_without_authorization()
    {
        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/assignments/'. $createdAssignment->id);
        $response->assertStatus(401);
    }

    public function test_assignment_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/assignments?page=1&per_page=3');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_assignment_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/assignments?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_assignment_can_not_show_assignment_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/assignments/'. 0);
        $response->assertStatus(404);
    }

    public function test_assignment_can_not_update_assignment_with_invalid_id()
    {
        $this->authenticate();;

        $createdClient = Client::factory()->create();
        $createdStatus = Status::factory()->create();
        $createdAssignment = Assignment::factory()->create(
            ['id_clients' => $createdClient->id, 'id_statuses' => $createdStatus->id]
        );

        $response = $this->patch('/api/v1/assignments/'. 0, $createdAssignment->toArray());
        $response->assertStatus(404);
    }

    public function test_assignments_can_not_delete_assignment_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/assignments/'. 0);
        $response->assertStatus(404);
    }
}

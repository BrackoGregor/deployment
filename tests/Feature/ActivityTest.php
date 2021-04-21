<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\Activity;

class ActivityTest extends TestCase
{

    //RULES
    //#1 you are not allowed to write any production code, until you've first written a test that fails
    //#2 you are not allowed to write more of a test, then it's sufficient to fail. As soon as test fails, you've must stop writing it
    //#3 you are not allowed to write any production code than it's sufficient to pass current failing test
    //Programmers write tests for their own code!
    //RULES

    public function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function test_activity_can_create()
    {
        $this->authenticate();

        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->post('/api/v1/activities', $createdActivity->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('activities', $createdActivity->toArray());
    }

    public function test_activity_can_not_create_without_authorization ()
    {
        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('POST','/api/v1/activities', $createdActivity->toArray());
        $response->assertStatus(401);
    }

    public function test_activity_can_delete()
    {
        $this->authenticate();

        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->delete('/api/v1/activities/'. $createdActivity->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('activities', $createdActivity->toArray());
    }

    public function test_activity_can_not_delete_without_authorization()
    {
        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('DELETE','/api/v1/activities/'. $createdActivity->id);
        $response->assertStatus(401);
    }

    public function test_activity_can_update()
    {
        $this->authenticate();

        $createdAssignment = Assignment::factory()->create();
        $createdActivityDb = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $createdAssignmentDb = Assignment::factory()->create();
        $createdActivity = Activity::factory()->make(
            ['id_assignments' => $createdAssignmentDb->id]
        );

        $response = $this->patch('/api/v1/activities/'. $createdActivityDb->id, $createdActivity->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('activities', $createdActivity->toArray());
    }

    public function test_activity_can_not_update_without_authorization()
    {
        $createdAssignment = Assignment::factory()->create();
        $createdActivityDb = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $createdAssignmentDb = Assignment::factory()->create();
        $createdActivity = Activity::factory()->make(
            ['id_assignments' => $createdAssignmentDb->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('PUT','/api/v1/activities/'. $createdActivityDb->id, $createdActivity->toArray());
        $response->assertStatus(401);
    }

    public function test_activity_can_show()
    {
        $this->authenticate();

        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->get('/api/v1/activities/'. $createdActivity->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('activities', $createdActivity->toArray());
    }

    public function test_activity_can_not_show_without_authorization()
    {
        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/activities/'. $createdActivity->id);
        $response->assertStatus(401);
    }

    public function test_activity_can_get_all()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/activities');
        $response->assertStatus(200);
    }

    public function test_activity_can_not_get_all_without_authorization()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer nebodelalo'
        ])->json('GET','/api/v1/activities?page=1&per_page=3');
        $response->assertStatus(401);
    }

    public function test_activity_can_not_show_activity_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->get('/api/v1/activities/'. 0);
        $response->assertStatus(404);
    }

    public function test_activity_can_not_update_activity_with_invalid_id()
    {
        $this->authenticate();

        $createdAssignment = Assignment::factory()->create();
        $createdActivity = Activity::factory()->create(
            ['id_assignments' => $createdAssignment->id]
        );

        $response = $this->patch('/api/v1/activities/'. 0, $createdActivity->toArray());
        $response->assertStatus(404);
    }

    public function test_activity_can_not_delete_activity_with_invalid_id()
    {
        $this->authenticate();

        $response = $this->delete('/api/v1/activities/'. 0);
        $response->assertStatus(404);
    }
}

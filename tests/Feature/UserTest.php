<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    const PASSWORD = 'password';

    /** @test */
    public function test_successful_register()
    {
        //Fake User
        $user = User::factory()->make();
        $payload = array_merge($user->toArray(), ['password' => self::PASSWORD], ['password_confirmation' => self::PASSWORD]);

        //Disable Exception handling
        // $this->withoutExceptionHandling();

        //Debug response body
        //$response->getContent();

        $this->postJson('api/users', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data" => [
                    "id",
                    "name",
                    "email",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }

    /** @test */
    public function test_register_without_data()
    {
        $this->postJson('api/users')
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors",
            ]);
    }

    /** @test */
    public function test_list_all_users_index()
    {
        //Fake User
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->getJson('api/users')
            ->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "data" => []
            ]);
    }

    /** @test */
    public function test_show_user_by_id()
    {
        //Fake User
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->getJson('api/users/' . $user->id)
            ->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "data" => []
            ]);
    }

    /** @test */
    public function test_update_user()
    {
        //Fake User
        $user = User::factory()->create();

        //Payload
        $fakeData = User::factory()->make();
        $payload = array_merge($fakeData->toArray(), ['password' => self::PASSWORD], ['password_confirmation' => self::PASSWORD]);
        $this->putJson('api/users/' . $user->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "data" => []
            ]);
    }

    /** @test */
    public function test_delete_user_by_id()
    {
        //Fake User
        $user = User::factory()->create();
        $this->deleteJson('api/users/' . $user->id)->assertStatus(204);
    }
}

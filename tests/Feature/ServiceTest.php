<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers   \App\Http\Controllers\ServiceController
 */
class ServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ServiceSeeder::class);
    }


    public function test_unverified_user_can_not_see_list_of_services()
    {
        $user = $this->create(User::class, ['email_verified_at' => null]);
        $this->actingAs($user);


        $this->getJson('api/services')->assertStatus(403);
    }

    public function test_verified_user_can_see_list_of_services()
    {
        $user = $this->create(User::class);
        $this->actingAs($user);


        $this->getJson('api/services')->assertExactJson(['data' =>
            [
                [
                    'id' => 1,
                    "title" => "service1"
                ],
                [
                    'id' => 2,
                    "title" => "service2"
                ],
                [
                    'id' => 3,
                    "title" => "service3"
                ]
            ]
        ]);
    }
}

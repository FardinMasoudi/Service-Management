<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\TicketController
 */
class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_user_can_see_list_of_own_tickets()
    {
        $user = $this->create(User::class);
        $this->actingAs($user);

        $this->create(Ticket::class, ['user_id' => $user->id], 2);

        $this->getJson('api/tickets')
            ->assertJsonStructure(['data' => [
                [
                    'id',
                    'title',
                    'description',
                    'service'
                ]
            ]]);
    }

    public function test_unverified_user_can_not_create_ticket()
    {
        $user = $this->create(User::class, ['email_verified_at' => null]);
        $this->actingAs($user);

        $this->postJson('api/tickets', [
            'title' => 'ticket title',
            'description' => 'ticket description',
            'service_id' => $this->create(Service::class)->id,
        ])->assertStatus(403);
    }


    public function test_verified_user_can_create_ticket()
    {
        $user = $this->create(User::class,);
        $this->actingAs($user);

        $this->postJson('api/tickets', [
            'title' => 'ticket title',
            'description' => 'ticket description',
            'service_id' => $this->create(Service::class)->id,
        ])->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketSmsNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\Admin\TicketController
 */
class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_list_of_users_tickets()
    {
        $admin = $this->create(User::class);
        $this->actingAs($admin);

        $this->create(Ticket::class, [], 2);

        $this->getJson('api/admin/tickets')
            ->assertJsonStructure(['data' => [
                [
                    'id',
                    'title',
                    'user',
                    'description',
                    'service'
                ]
            ]]);
    }

    public function test_admin_can_see_detail_of_ticket_and_must_be_send_notification_to_user()
    {
        Notification::fake();

        $admin = $this->create(User::class);
        $this->actingAs($admin);

        $ticket = $this->create(Ticket::class, ['status' => Ticket::STATUSES['PENDING']]);

        $this->getJson('api/admin/tickets/' . $ticket->id)
            ->assertJsonStructure(['data' =>
                [
                    'id',
                    'title',
                    'user',
                    'description',
                    'service'
                ]
            ]);
        $ticket->refresh();

        Notification::assertSentTo(
            [$ticket],
            function (TicketSmsNotification $notification) use ($ticket) {
                $smsData = $notification->toSms($ticket);
                $this->assertStringContainsString(Ticket::STATUSES['SEENBYADMIN'], $smsData->description);

                return true;
            }
        );
    }

    public function test_admin_can_change_ticket_status_to_cancel_or_completed()
    {
        Notification::fake();

        $admin = $this->create(User::class);
        $this->actingAs($admin);

        $ticket = $this->create(Ticket::class, [
            'status' => Ticket::STATUSES['SEENBYADMIN']
        ]);

        $this->patchJson('api/admin/tickets/' . $ticket->id, [
            'status' => Ticket::STATUSES['CANCEL']
        ])->assertStatus(200);


        $this->assertDatabaseHas('tickets', [
            'status' => Ticket::STATUSES['CANCEL']
        ]);

        Notification::assertSentTo(
            [$ticket],
            function (TicketSmsNotification $notification) use ($ticket) {
                $smsData = $notification->toSms($ticket);
                $this->assertStringContainsString($ticket->status, $smsData->description);
                return true;
            }
        );
    }
}

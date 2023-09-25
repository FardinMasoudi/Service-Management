<?php

namespace Tests\Unit;


use App\Http\Services\VerificationCodeDrivers\VerificationCodeService;
use App\Mail\VerificationCodeEmail;
use App\Models\User;
use App\Notifications\Messages\SmsMessage;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerificationCodeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_system_can_send_verification_code_to_user_via_sms()
    {
        $user = $this->create(User::class);

        $smsMessageMock = $this->mock(SmsMessage::class)
            ->makePartial();

        $smsMessageMock->shouldReceive('send')
            ->andReturn(
                new Response(200, [], json_encode([
                    'data' => 'send'
                ]))
            );

        app()->instance(SmsMessage::class, $smsMessageMock);

        $verificationService = app(VerificationCodeService::class);
        $verificationService->sendVerificationCode($user, 'sms');

        $smsMessageMock->shouldHaveReceived('send')->times(1);

        $this->assertDatabaseHas('verification_codes', [
            'user_id' => $user->id,
            'driver' => 'sms'
        ]);
    }

    public function test_system_throw_exception_with_invalid_driver()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid driver:invalid-driver');

        $user = $this->create(User::class);

        $verificationService = app(VerificationCodeService::class);
        $verificationService->sendVerificationCode($user, 'invalid-driver');
    }

    public function test_system_can_send_verification_code_to_user_via_email()
    {
        Mail::fake();

        $user = $this->create(User::class);

        $verificationService = app(VerificationCodeService::class);
        $verificationService->sendVerificationCode($user, 'email');

        Mail::assertSent(VerificationCodeEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        $this->assertDatabaseHas('verification_codes', [
            'user_id' => $user->id,
            'driver' => 'email'
        ]);
    }
}

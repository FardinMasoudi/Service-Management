<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_verify_account_with_valid_verification_code()
    {
        $user = $this->create(User::class, [
            'email_verified_at' => null
        ]);

        $this->actingAs($user);

        $this->create(VerificationCode::class, [
            'user_id' => $user->id,
            'driver' => 'email',
            'code' => '123456'
        ]);

        $this->patch('api/users/' . $user->id . '/verify', [
            'driver' => 'email',
            'code' => '123456'
        ])->assertStatus(200);

        $user->refresh();

        $this->assertNotNull($user->email_verified_at);
    }

    public function test_user_can_not_verify_account_with_invalid_verification_code()
    {
        $user = $this->create(User::class, [
            'email_verified_at' => null
        ]);

        $this->actingAs($user);

        $this->create(VerificationCode::class, [
            'user_id' => $user->id,
            'driver' => 'mobile',
            'code' => '123456'
        ]);

        $this->patch('api/users/' . $user->id . '/verify', [
            'driver' => 'sms',
            'code' => '123412' // invalid verification code
        ])->assertStatus(401);

        $user->refresh();

        $this->assertNull($user->email_verified_at);
    }
}

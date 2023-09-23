<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\LoginController
 */
class loginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credential(): void
    {
        $user = $this->create(User::class, [
            'email' => '70ardin@gmail.com',
            'password' => '123456']);

        $this->postJson('api/login', [
            'email' => $user->email,
            'password' => '123456'
        ])->dd();
    }
}

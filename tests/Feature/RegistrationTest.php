<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers   \App\Http\Controllers\RegistrationController
 */
class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider RegistrationInvalidData
     */
    public function test_registration_validation_params($registrationData, $fields, $statusCode): void
    {

        $response = $this->postJson('api/registration', $registrationData);

        $response->assertJsonValidationErrors($fields);
        $response->assertStatus($statusCode);
    }

    public function test_user_can_register_with_valid_credential()
    {
        $this->postJson('api/registration', [
            'name' => 'fardin',
            'email' => '70ardin@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'fardin'
        ]);
    }

    public static function RegistrationInvalidData(): array
    {
        return [
            [
                ['name' => '', 'email' => '', 'password' => ''],
                ['name', 'email', 'password'],
                422
            ],
            [
                ['name' => 'fa', 'email' => 'invalidEmail', 'password' => '12345678'],
                ['name', 'email', 'password'],
                422
            ],
            [
                ['name' => 'fardinMasoudi124578', 'email' => 'invalidEmail', 'password' => '12'],
                ['name', 'email', 'password'],
                422
            ],
            [
                [
                    'name' => 'fardin', 'email' => '70ardin@gmail.com',
                    'password' => '12345678', 'password_confirmation' => '123456'
                ],
                ['password'],
                422
            ]
        ];
    }
}

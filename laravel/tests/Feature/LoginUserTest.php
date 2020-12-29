<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    public function testLoginShouldReturnErrorOnInvalidParams()
    {
        $loginUrl = '/api/login';
        $email = 'admin@superhelper.id';

        // empty password
        $data = [
            'email' => $email,
            'password' => '',
        ];

        $response = $this->postJson($loginUrl, $data);

        $response->assertStatus(422);

        // empty email
        $data = [
            'email' => '',
            'password' => '123456789',
        ];

        $response = $this->postJson($loginUrl, $data);

        $response->assertStatus(422);
    }

    public function testLoginShouldReturnErrorOnInvalidCredential()
    {
        $loginUrl = '/api/login';
        $email = 'admin@superhelper.id';
        $password = '123456789';
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->postJson($loginUrl, $data);

        $response->assertStatus(422);
    }
}

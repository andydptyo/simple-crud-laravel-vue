<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testRegisterShouldReturnErrorOnInvalidParams()
    {
        $registerUrl = '/api/register';

	    // empty password
        $data = [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'birthday' => $this->faker->date('Y-m-d'),
            'city_id' => 1,
        ];

        $response = $this->postJson($registerUrl, $data);

        $response->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'password' => [
                    'kata sandi wajib diisi.'
                ]
            ]
        ]);

	    // empty email
        $data = [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'password' => $this->faker->password,
            'birthday' => $this->faker->date('Y-m-d'),
            'city_id' => 1,
        ];

        $response = $this->postJson($registerUrl, $data);

        $response->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'alamat email wajib diisi.'
                ]
            ]
        ]);
    }

    public function testRegisterShouldReturnHttpCreatedOnSuccess()
    {
        $registerUrl = '/api/register';

        $data = [
            'first_name' => 'Andy',
            'last_name' => 'Dwi Prasetyo',
            'email' => 'andy.dptyo@gmail.com',
            'password' => '123456789',
            'birthday' => '1989-05-12',
            'city_id' => 3,
        ];

        $response = $this->postJson($registerUrl, $data);

        $response->assertStatus(201)
        ->assertJson([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }

    public function testRegisterShouldReturnErrorOnUniqueFields()
    {
        $registerUrl = '/api/register';
        $phone = '123456789';
        $email = 'andy.dptyo@gmail.com';

        $data = [
            'first_name' => 'Andy',
            'last_name' => 'Dwi Prasetyo',
            'phone' => $phone,
            'email' => $email,
            'password' => '123456789',
            'birthday' => '1989-05-12',
            'city_id' => 3,
        ];

        User::create($data);

        // test unique email
        $data['phone'] = '081232252562';

        $response = $this->postJson($registerUrl, $data);

        $response->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'alamat email sudah ada sebelumnya.'
                ]
            ]
        ]);

        // test unique phone
        $data['email'] = 'andy.dptyo@gmail.com';
        $data['phone'] = '123456789';

        $response = $this->postJson($registerUrl, $data);

        $response->assertStatus(422)
        ->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'phone' => [
                    'telepon sudah ada sebelumnya.'
                ]
            ]
        ]);
    }
}

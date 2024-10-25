<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'image' => 'avatar.jpg',
            'username' => 'test',
            'name' => 'Test Test',
            'email' => 'test@gmail.com',
            'password' => 'pass1234',
            'password_confirmation' => 'pass1234',
        ];
    }

    protected function registerUser(): User
    {
        $userData = $this->data;
        unset($userData['password_confirmation']);

        $userData['password'] = Hash::make($this->data['password']);

        return User::create(array_merge($userData));
    }

    public function test_create_user_successfully(): void
    {
        $response = $this->postJson('api/auth/register', $this->data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'image',
                    'username',
                    'name',
                    'email',
                ],
                "token"
            ]);
    }
    public function test_create_user_email_already(): void
    {


        $firstResponse = $this->postJson("api/auth/register", $this->data);
        $firstResponse->assertStatus(201);

        $secondResponse = $this->postJson("api/auth/register", $this->data);
        $secondResponse->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "email"
            ],
        ]);;
    }

    public function test_user_can_login_and_receive_jwt(): void
    {
        $this->registerUser();

        $response = $this->postJson('/api/auth/login', [
            'email' => $this->data['email'],
            'password' => $this->data['password'],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }
    public function test_protected_route_access_with_jwt(): void
    {
        $this->registerUser();

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => $this->data['email'],
            'password' => $this->data['password'],
        ]);

        $token = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token,
        ])->getJson('/api/auth/me');

        $response->assertStatus(200);
    }
}

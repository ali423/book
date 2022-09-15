<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function test_login_with_not_exits_email()
    {
        $response = $this->postJson(route('login'), [
            'email' => fake()->email(),
            'password' => fake()->password(),
        ]);
        $response->assertStatus(422);
    }

    public function test_login_with_wrong_email_format()
    {
        $response = $this->postJson(route('login'), [
            'email' => fake()->name(),
            'password' => fake()->password(),
        ]);
        $response->assertStatus(422);
    }

    public function test_login_without_email()
    {
        $response = $this->postJson(route('login'), [
            'password' => fake()->password(),
        ]);
        $response->assertStatus(422);
    }

    public function test_login_without_password()
    {
        $email = fake()->unique()->safeEmail();
        $password = fake()->password();
        User::query()->create([
            'name' => fake()->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $response = $this->postJson(route('login'), [
            'email' => $email,
        ]);
        $response->assertStatus(422);
    }

    public function test_login_wrong_password()
    {
        $email = fake()->unique()->safeEmail();
        $password = fake()->password();
        User::query()->create([
            'name' => fake()->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $response = $this->postJson(route('login'), [
            'email' => $email,
            'password' => fake()->password(),
        ]);
        $response->assertStatus(500);
    }

    public function test_login_correct_data()
    {
        $email = fake()->unique()->safeEmail();
        $password = fake()->password();
        Artisan::call('passport:install', ['-vvv' => true]);
        User::query()->create([
            'name' => fake()->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $response = $this->postJson(route('login'), [
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
            ]
        ]);
    }

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookSearchTest extends TestCase
{
    use DatabaseMigrations;

    public function test_avoid_guest_user()
    {
        $response = $this->postJson(route('search.book'));
        $response->assertStatus(401);
    }

    public function test_get_data_with_wrong_filter()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        $response = $this->postJson(route('search.book'), [
            'keyword' => array(),
        ]);
        $response->assertStatus(422);
    }

    public function test_get_data_without_filter()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        $response = $this->postJson(route('search.book'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'image_name',
                    'publishers',
                    'id',
                    'title',
                    'content',
                    'slug',
                    'authors' => [
                        '*' => [
                            'name',
                        ]
                    ]
                ],
            ],
        ]);
    }

    public function test_get_data_with_filter()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        $response = $this->postJson(route('search.book'), [
            'keyword' => fake()->asciify('********************'),
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [

            ],
        ]);
    }
}

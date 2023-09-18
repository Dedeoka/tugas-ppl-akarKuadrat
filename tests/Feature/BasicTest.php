<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Generator as Faker;
use Database\Factories;

class BasicTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function it_stores_data()
    {
        // $bilangan = factory(Test::class)->create();
        $response = $this
        ->post(route('test.store'), [
            'bilangan' => fake()->randomNumber(3)
        ]);

        $response->assertStatus(200);
    }
}

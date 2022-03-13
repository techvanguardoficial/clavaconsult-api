<?php

namespace Tests\Feature;

use App\Models\Specialty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialtyTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function test_index_without_params()
    {
        $response = $this->getJson('/specialties');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_show_specialty()
    {
        $specialty = Specialty::create([
            'name' => $this->faker->word()
        ]);

        $response = $this->getJson('/specialties/' . $specialty->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * @return void
     */
    public function test_store_specialty_successfully()
    {
        $response = $this->postJson('/specialties', [
            'name' => $this->faker->word()
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'name',
            'created_at',
            'updated_at'
        ]);
    }

    public function test_cant_store_invalid_specialty()
    {
        //
    }

    public function test_validate_name_field_required_on_create()
    {
        $response = $this->postJson('/specialties', []);

        $response->assertStatus(422);
    }

    public function test_validate_name_field_as_string_on_create()
    {
        $response = $this->postJson('/specialties', [
            'name' => $this->faker->randomNumber()
        ]);

        $response->assertStatus(422);
    }

    public function test_validate_name_field_min_length_on_create()
    {
        $response = $this->postJson('/specialties', [
            'name' => $this->faker->lexify('??')
        ]);

        $response->assertStatus(422);
    }

    public function test_validate_name_field_max_length_on_create()
    {
        $response = $this->postJson('/specialties', [
            'name' => $this->faker->text(256)
        ]);

        // $response->assertStatus(422);
    }
}

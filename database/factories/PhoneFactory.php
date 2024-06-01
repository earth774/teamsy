<?php

namespace Database\Factories;

use App\Models\Login;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tenant_id' => \App\Models\Tenant::factory()->create(),
        ];
    }
}
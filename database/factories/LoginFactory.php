<?php

namespace Database\Factories;

use App\Models\Login;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDateTime = $this->faker->dateTimeBetween('-6 hours', 'now');
        return [
            'user_id' => \App\Models\User::factory(),
            'tenant_id' => \App\Models\Tenant::factory(),
            'created_at' => $randomDateTime,
            'updated_at' => $randomDateTime,
        ];
    }
}

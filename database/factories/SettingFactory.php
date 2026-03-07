<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group' => 'general',
            'key' => fake()->unique()->slug(2, '_'),
            'value' => fake()->sentence(),
            'type' => 'string',
            'autoload' => true,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_name' => $this->faker->name(),
            'author_description' => $this->faker->paragraph(rand(2, 6)),
            'author_year_of_birth' => $this->faker->year(1971),
            'author_year_of_death' => rand(0, 1) ? $this->faker->year() : null
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_title' => $this->faker->title(),
            'book_description' => $this->faker->paragraph(),
            'book_publish_year' => $this->faker->year(),
            'language_id' => Language::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'book_page_count' => rand(60, 200),
            'book_price' => rand(1, 199) * 100,
            'book_image_path' => null,
        ];
    }
}

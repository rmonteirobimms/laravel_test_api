<?php

namespace Database\Factories;

use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $slugify = new Slugify();
        return [
            'name' => $name,
            'description' =>  fake()->sentences(5, true),
            'price' => fake()->numberBetween(1000,10000),
            'slug' => $slugify->slugify($name)
        ];
    }
}

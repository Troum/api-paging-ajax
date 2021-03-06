<?php

namespace Database\Factories;

use App\Models\Tile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'steamid' => $this->faker->word,
        'defid' => $this->faker->randomDigitNotNull,
        'quality' => $this->faker->randomDigitNotNull,
        'attributes' => $this->faker->text,
        'hash' => $this->faker->word,
        'slot' => $this->faker->randomDigitNotNull
        ];
    }
}

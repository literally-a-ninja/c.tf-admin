<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'steamid' => $this->faker->word,
        'alias' => $this->faker->word,
        'name' => $this->faker->word,
        'motd' => $this->faker->text,
        'avatar' => $this->faker->text,
        'token' => $this->faker->word,
        'bans' => $this->faker->randomDigitNotNull,
        'special' => $this->faker->randomDigitNotNull,
        'admin' => $this->faker->randomDigitNotNull,
        'connections' => $this->faker->text,
        'loadout' => $this->faker->text,
        'settings' => $this->faker->text,
        'queried' => $this->faker->randomDigitNotNull,
        'exp' => $this->faker->randomDigitNotNull,
        'credit' => $this->faker->randomDigitNotNull,
        'contract' => $this->faker->randomDigitNotNull,
        'owner' => $this->faker->text,
        'lastlogin' => $this->faker->word,
        'lastserver' => $this->faker->word,
        'backpack_pages' => $this->faker->randomDigitNotNull,
        'presence' => $this->faker->text
        ];
    }
}

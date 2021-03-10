<?php

namespace Database\Factories;

use App\Http\Repositories\StackRepository;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class DeveloperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Developer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $stacksRepository = new StackRepository();


        return [
            'status' =>  Arr::random([0,1,2], 1)[0],
            'position' => Arr::random(developerPositions(), 1)[0],
            'creator_id' => User::inRandomOrder()->first()->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];
    }
}

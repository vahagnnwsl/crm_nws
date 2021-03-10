<?php

namespace Database\Factories;

use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\OrderRepository;
use App\Models\Agent;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $developerRepository = new DeveloperRepository();

        return [
            'name' => $this->faker->domainName,
            'created_at' => $this->faker->dateTimeBetween('-1 years', '+0 days'),
            'expert_id' => Arr::random($developerRepository->getAccepted()->pluck('id')->toArray(), 1)[0],
            'developer_id' => Arr::random($developerRepository->getAccepted()->pluck('id')->toArray(), 1)[0],
            'team_lid_id' => Arr::random($developerRepository->getAccepted()->pluck('id')->toArray(), 1)[0],
            'agent_id' => Agent::inRandomOrder()->first()->id,
            'creator_id' => User::inRandomOrder()->first()->id,
            'link' => $this->faker->url,
            'source' => Arr::random(orderSources(), 1)[0],
            'status' => rand(0, 12)
        ];
    }
}

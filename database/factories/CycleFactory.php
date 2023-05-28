<?php

namespace Database\Factories;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shetabit\Multipay\Payment;

class CycleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cycle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first' => 1_000_000,
            'end' => 10_000_000,
            'percentage' => 100,
            'drives' => ['zarinpal'], 
        ];
    }
}

<?php

namespace Database\Factories\Booking;

use App\Domain\Booking\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
class BookingFactory extends Factory
{
    protected $model = Booking::class;
    public function definition(): array
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
            'reason' => $this->faker->paragraph,
        ];
    }
}

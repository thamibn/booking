<?php

namespace Database\Seeders;

use App\Domain\Booking\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::factory()->count(100)->create();
    }
}

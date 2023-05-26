<?php

namespace App\Domain\Booking\Actions;

use App\Domain\Booking\DataTransferObjects\BookingData;
use App\Domain\Booking\Models\Booking;


class UpsertBookingAction
{
    public static function execute(BookingData $data): Booking
    {
        return Booking::create($data->all());
    }
}

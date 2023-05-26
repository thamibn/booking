<?php

namespace App\Domain\Booking\ViewModels;

use App\Domain\Booking\DataTransferObjects\BookingData;
use App\Domain\Booking\Models\Booking;
use Domain\Shared\ViewModels\BaseViewModel;

class UpsertBookingViewModel extends BaseViewModel
{
    public function __construct(public readonly ?Booking $booking = null)
    {
    }

    public function booking(): ?BookingData
    {
        if (!$this->booking) {
            return null;
        }

        return $this->booking->getData();
    }
}

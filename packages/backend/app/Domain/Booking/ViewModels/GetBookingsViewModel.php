<?php

namespace App\Domain\Booking\ViewModels;

use App\Domain\Booking\DataTransferObjects\BookingData;
use App\Domain\Booking\Models\Booking;
use Domain\Shared\ViewModels\BaseViewModel;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetBookingsViewModel extends BaseViewModel
{
    public function __construct(private readonly int $currentPage = 10)
    {
    }

    public function bookings()
    {

        Log::debug(request()->query());

        $bookings = QueryBuilder::for(Booking::query())
            ->defaultSort('date')
            ->allowedSorts('date', 'reason')
            ->allowedFilters([
                'date',
                AllowedFilter::scope('from_date'),
                AllowedFilter::scope('to_date'),
            ])
            ->paginate($this->currentPage)
            ->appends(request()->query());

        return BookingData::collection($bookings);
    }

    public function total(): int
    {
        return Booking::count();
    }

}

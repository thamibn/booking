<?php

namespace App\Http\Controllers\API;

use App\Domain\Booking\Actions\UpsertBookingAction;
use App\Domain\Booking\DataTransferObjects\BookingData;
use App\Domain\Booking\ViewModels\GetBookingsViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->resultsPerPage ?: 10;
        return new GetBookingsViewModel($per_page);
    }

    public function store(BookingData $request)
    {
        UpsertBookingAction::execute($request);

        return response()->json([
           'message' => "Booking Created successfully"
        ]);
    }
}

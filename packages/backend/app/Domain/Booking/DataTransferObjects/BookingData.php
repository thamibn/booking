<?php

namespace App\Domain\Booking\DataTransferObjects;

use App\Domain\Booking\Models\Booking;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class BookingData extends Data
{
    public function __construct(
        public readonly ?string $uuid,
        public readonly string  $date,
        public readonly string  $reason,
    )
    {}

    public static function fromRequest(Request $request): static
    {
        return self::from([
            ...$request->all(),
        ]);
    }

    public static function fromModel(Booking $booking): self
    {
        return self::from([
            ...$booking->toArray(),
        ]);
    }

    public static function rules(): array
    {
        return [
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'reason' => ['required', 'min:3'],
        ];
    }
}

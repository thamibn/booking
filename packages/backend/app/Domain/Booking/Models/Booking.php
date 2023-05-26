<?php

namespace App\Domain\Booking\Models;

use App\Domain\Booking\DataTransferObjects\BookingData;
use App\Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\LaravelData\WithData;

class Booking extends BaseModel
{
    use hasUuids;
    use withData;
    protected string $dataClass = BookingData::class;
    protected $fillable = [
        'date',
        'reason',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function scopeFromDate(Builder $query, $date): Builder
    {
        return $query->where('date', '>=', $date);
    }
    public function scopeToDate(Builder $query, $date): Builder
    {
        return $query->where('date', '<=', $date);
    }
}

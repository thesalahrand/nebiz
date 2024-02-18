<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreOpeningHour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'day_of_week',
        'is_closed',
        'opens_at',
        'closes_at'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}

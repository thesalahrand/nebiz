<?php

namespace App\Models;

use App\Utils\GetDistanceBetweenTwoGeoPoints;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Store extends Model implements HasMedia
{
    public const SEED_AMOUNT_PER_STORE_TYPE = 3;
    private const MY_FIXED_LATITUDE = 22.711555;
    private const MY_FIXED_LONGITUDE = 90.3609395;

    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'store_type_id',
        'name',
        'address',
        'area',
        'city',
        'postal_code',
        'phone',
        'email',
        'website',
        'latitude',
        'longitude',
        'cover',
        'additional_text'
    ];

    protected function distance(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes): float => GetDistanceBetweenTwoGeoPoints::execute($attributes['latitude'], $attributes['longitude']),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(StoreOpeningHour::class, 'store_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(StoreType::class, 'store_type_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(384);
    }
}

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
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model implements HasMedia
{
    private const MY_FIXED_LATITUDE = 22.711555;
    private const MY_FIXED_LONGITUDE = 90.3609395;

    use HasFactory, SoftDeletes, HasSlug, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'store_type_id',
        'name',
        'slug',
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
        'additional_info'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function distance(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes): float => GetDistanceBetweenTwoGeoPoints::execute($attributes['latitude'], $attributes['longitude']),
        );
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                $value = $attributes['address'];
                if ($attributes['area'])
                    $value .= ', ' . $attributes['area'];
                if ($attributes['city'])
                    $value .= ', ' . $attributes['city'];
                if ($attributes['postal_code'])
                    $value .= ' - ' . $attributes['postal_code'];

                return $value;
            },
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

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleted(function (Store $store) {
            $store->openingHours()->delete();
        });
    }
}

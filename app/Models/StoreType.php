<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreType extends Model
{
    public const SEED_AMOUNT = 15;

    use HasFactory;

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}

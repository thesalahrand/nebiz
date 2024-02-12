<?php
namespace App\Enums;

use Illuminate\Support\Collection;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public static function toCollection(): Collection
    {
        return collect([
            ['name' => 'Male', 'value' => static::MALE->value],
            ['name' => 'Female', 'value' => static::FEMALE->value],
            ['name' => 'Other', 'value' => static::OTHER->value],
        ]);
    }
}
?>
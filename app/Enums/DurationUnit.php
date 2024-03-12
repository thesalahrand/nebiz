<?php
namespace App\Enums;

use Illuminate\Support\Collection;

enum DurationUnit: string
{
    case SECOND = 'seconds';
    case MINUTE = 'minutes';
    case HOUR = 'hours';
    case DAY = 'days';
    case MONTH = 'months';
    case YEAR = 'years';

    public static function toCollection(): Collection
    {
        return collect([
            ['name' => 'Seconds', 'value' => static::SECOND->value],
            ['name' => 'Minutes', 'value' => static::MINUTE->value],
            ['name' => 'Hours', 'value' => static::HOUR->value],
            ['name' => 'Days', 'value' => static::DAY->value],
            ['name' => 'Months', 'value' => static::MONTH->value],
            ['name' => 'Years', 'value' => static::YEAR->value],
        ]);
    }
}
?>
<?php
namespace App\Enums;

use Illuminate\Support\Collection;

enum Unit: string
{
    case OTHERS_UNIT = 'unit';
    case WEIGHT_MG = 'mg';
    case WEIGHT_G = 'g';
    case WEIGHT_KG = 'kg';
    case WEIGHT_LB = 'lb';
    case WEIGHT_T = 't';
    case VOLUME_ML = 'mL';
    case VOLUME_L = 'L';
    case VOLUME_GAL = 'gal';
    case VOLUME_BBL = 'bbl';
    case LENGTH_MM = 'mm';
    case LENGTH_CM = 'cm';
    case LENGTH_IN = 'in';
    case LENGTH_FT = 'ft';
    case LENGTH_YD = 'yd';
    case LENGTH_M = 'm';

    public static function toCollection(): Collection
    {
        return collect([
            [
                'label' => 'Others',
                'options' => [
                    ['name' => 'unit', 'value' => static::OTHERS_UNIT->value]
                ]
            ],
            [
                'label' => 'Weights',
                'options' => [
                    ['name' => 'mg (milligram)', 'value' => static::WEIGHT_MG->value],
                    ['name' => 'g (gram)', 'value' => static::WEIGHT_G->value],
                    ['name' => 'lb (pound)', 'value' => static::WEIGHT_LB->value],
                    ['name' => 'kg (kilogram)', 'value' => static::WEIGHT_KG->value],
                    ['name' => 't (ton)', 'value' => static::WEIGHT_T->value],
                ]
            ],
            [
                'label' => 'Volumes',
                'options' => [
                    ['name' => 'mL (milliliter)', 'value' => static::VOLUME_ML->value],
                    ['name' => 'L (liter)', 'value' => static::VOLUME_L->value],
                    ['name' => 'gal (gallon)', 'value' => static::VOLUME_GAL->value],
                    ['name' => 'bbl (barrel)', 'value' => static::VOLUME_BBL->value],
                ]
            ],
            [
                'label' => 'Lengths',
                'options' => [
                    ['name' => 'mm (millimeter)', 'value' => static::LENGTH_MM->value],
                    ['name' => 'cm (centimeter)', 'value' => static::LENGTH_CM->value],
                    ['name' => 'in (inch)', 'value' => static::LENGTH_IN->value],
                    ['name' => 'ft (feet)', 'value' => static::LENGTH_FT->value],
                    ['name' => 'yd (yard)', 'value' => static::LENGTH_YD->value],
                    ['name' => 'm (meter)', 'value' => static::LENGTH_M->value],
                ]
            ],
        ]);
    }
}
?>
<?php

namespace Tithe\Enums;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

enum PeriodicityTypeEnum: string
{
    case YEAR = 'year';
    case MONTH = 'month';
    case WEEK = 'week';
    case DAY = 'day';

    public function label(): string
    {
        return match($this) 
        {
            self::YEAR => 'Yearly',
            self::MONTH => 'Monthly',
            self::WEEK => 'Weekly',
            self::DAY => 'Daily',
        };
    }

    public static function getDateDifference(Carbon $from, Carbon $to, string $unit): int
    {
        $unitInPlural = Str::plural($unit);

        $differenceMethodName = 'diffIn'.$unitInPlural;

        return $from->{$differenceMethodName}($to);
    }
}

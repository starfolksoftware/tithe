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

    public function billingCycleRatio(): float
    {
        return match($this) 
        {
            self::YEAR => 12,
            self::MONTH => 1,
            self::WEEK => 0.25,
            self::DAY => 0.0333,
        };
    }

    public function noOfDays(): float
    {
        return match($this) 
        {
            self::YEAR => 365,
            self::MONTH => 30.437,
            self::WEEK => 14,
            self::DAY => 1,
        };
    }

    public static function getDateDifference(Carbon $from, Carbon $to, string $unit): int
    {
        $unitInPlural = Str::plural($unit);

        $differenceMethodName = 'diffIn' . $unitInPlural;

        return $from->{$differenceMethodName}($to);
    }

    public static function proration(mixed $subscriber, mixed $newPlan): float
    {
        $currentPlan = $subscriber->subscription?->plan;

        if (is_null($currentPlan) || $newPlan->amount <= $currentPlan->amount) {
            return 0.00;
        }

        $currentPeriodicity = self::from($currentPlan->periodicity_type);
        $remainingBillingCycleRatio = $currentPeriodicity->billingCycleRatio() - (
            ($subscriber->subscription->started_at->diffInDays(now()) /
                $currentPeriodicity->noOfDays()
            ) * $currentPeriodicity->billingCycleRatio()
        );

        return $newPlan->amount - ($currentPlan->amount * $remainingBillingCycleRatio);
    }
}

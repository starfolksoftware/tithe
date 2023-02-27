<?php

namespace Tithe;

use Illuminate\Support\Carbon;
use Tithe\Enums\PeriodicityType;

/**
 * Tithe\HandlesRecurrence
 *
 * @property mixed $periodicity_type
 * @property mixed $periodicity
 */
trait HandlesRecurrence
{
    public function calculateNextRecurrenceEnd(Carbon|string $start = null): Carbon
    {
        if (empty($start)) {
            $start = now();
        }

        if (is_string($start)) {
            $start = Carbon::parse($start);
        }

        $recurrences = PeriodicityType::getDateDifference(from: now(), to: $start, unit: $this->periodicity_type);
        $expirationDate = $start->copy()->add($this->periodicity_type, $this->periodicity + $recurrences);

        return $expirationDate;
    }
}

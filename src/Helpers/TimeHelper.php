<?php

namespace SquadMS\Foundation\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class TimeHelper {
    static function timeOfDay(Carbon $carbon = null) : string
    {
        if (is_null($carbon)) {
            $carbon = Carbon::now();
        }

        $hour = $carbon->format('H');

        if ($hour >= 6 && $hour < 10) {
            return 'Morgen';
        } else if ($hour >= 10 && $hour < 12) {
            return 'Vormittag';
        } else if ($hour >= 12 && $hour < 14) {
            return 'Mittag';
        } else if ($hour >= 14 && $hour < 17) {
            return 'Nachmittag';
        } else if ($hour >= 17 && $hour < 23) {
            return 'Abend';
        } else if ($hour >= 21 || $hour < 6) {
            return 'Nacht';
        }
    }

    public static function calculatePeriodsOverlap(CarbonPeriod $periodA, CarbonPeriod $periodB) : int
    {
        if (!$periodA->overlaps($periodB)) {
            return 0;
        }

        $firstEndDate = min($periodA->calculateEnd(), $periodB->calculateEnd());
        $latestStartDate = max($periodA->getStartDate(), $periodB->getStartDate());

        return $firstEndDate->diffInMinutes($latestStartDate);
    }
}
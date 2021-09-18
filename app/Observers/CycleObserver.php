<?php

namespace App\Observers;

use App\Models\Cycle;

class CycleObserver
{

    public function retrieved(Cycle $cycle)
    {
        $sum = $cycle->payments()->sum('amount');
        if ($sum >= $cycle->center && $cycle->is_equal_center) {
            $cycle->update([
                'center' => $sum
            ]);
        }

        if (is_null($cycle->ended_at) && $cycle->is_full) {
            $cycle->update([
                'ended_at' => now()
            ]);
        }
    }

    public function creating(Cycle $cycle)
    {
        $center = random_int($cycle->first / 1_000_000, $cycle->end / 1_000_000) * 1_000_000;

        $cycle->center = $cycle->second_center = $cycle->center ?? $center;
        $cycle->drives = $cycle->drives ?? ['pasargad', 'zarinpal'];
    }
}

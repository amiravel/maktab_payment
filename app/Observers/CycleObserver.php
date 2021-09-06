<?php

namespace App\Observers;

use App\Models\Cycle;

class CycleObserver
{
    /**
     * Handle the Cycle "created" event.
     *
     * @param \App\Models\Cycle $cycle
     * @return void
     */
    public function created(Cycle $cycle)
    {
        //
    }

    public function creating(Cycle $cycle)
    {
        $cycle->center = $cycle->center ?? random_int($cycle->first / 1_000_000, $cycle->end / 1_000_000) * 1_000_000;
        $cycle->drives = $cycle->drives ?? ['pasargad', 'zarinpal'];
    }

    /**
     * Handle the Cycle "updated" event.
     *
     * @param \App\Models\Cycle $cycle
     * @return void
     */
    public function updated(Cycle $cycle)
    {
        //
    }

    /**
     * Handle the Cycle "deleted" event.
     *
     * @param \App\Models\Cycle $cycle
     * @return void
     */
    public function deleted(Cycle $cycle)
    {
        //
    }

    /**
     * Handle the Cycle "restored" event.
     *
     * @param \App\Models\Cycle $cycle
     * @return void
     */
    public function restored(Cycle $cycle)
    {
        //
    }

    /**
     * Handle the Cycle "force deleted" event.
     *
     * @param \App\Models\Cycle $cycle
     * @return void
     */
    public function forceDeleted(Cycle $cycle)
    {
        //
    }
}

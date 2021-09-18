<?php

namespace App\Actions;

use App\Models\Cycle;
use Lorisleiva\Actions\Concerns\AsAction;

class GetActiveCycle
{
    use AsAction;

    public function handle()
    {
        $offset = 0;

        do {
            $cycle = Cycle::query()->latest()->offset($offset++)->first();
        } while (optional($cycle)->isFull);

        return $cycle ?? CreateNewCycle::run($cycle);
    }
}

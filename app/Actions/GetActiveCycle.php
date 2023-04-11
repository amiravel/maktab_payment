<?php

namespace App\Actions;

use App\Models\Cycle;
use Lorisleiva\Actions\Concerns\AsAction;

class GetActiveCycle
{
    use AsAction;

    public function handle()
    {
        return CreateNewCycle::run();
        if (Cycle::without('payments')->where('ended_at', null)->exists())
            return Cycle::without('payments')->latest()->first();
        else
            return CreateNewCycle::run();
    }
}

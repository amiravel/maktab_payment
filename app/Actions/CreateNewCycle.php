<?php

namespace App\Actions;

use App\Models\Cycle;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewCycle
{
    use AsAction;

    public function handle()
    {
        return Cycle::factory()->create();
    }
}

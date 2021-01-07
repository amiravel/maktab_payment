<?php

namespace App\Http\Livewire\Tables;

use App\Models\Payment;
use App\Models\Tag;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class PaymentsTable extends LivewireDatatable
{
    public function builder()
    {
        return Payment::query()
            ->with(['tags']);
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->linkTo('payments'),

            Column::name('name')
                ->searchable(),

            Column::name('mobile')
                ->searchable(),

            Column::name('email')
                ->searchable(),

            NumberColumn::name('amount')
                ->filterable(),

            Column::name('tags.name')
                ->filterable()
                ->filterable($this->tags()),

            Column::name('created_at')
                ->label('Created At')
                ->callback(['created_at'], function ($created_at) {
                    return jdate($created_at);
                }),
        ];
    }

    private function tags()
    {
        return Tag::query()
            ->whereNotNull('parent')
            ->pluck('name');
    }
}

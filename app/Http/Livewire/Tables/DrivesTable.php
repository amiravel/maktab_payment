<?php

namespace App\Http\Livewire\Tables;

use App\Models\Drive;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DrivesTable extends LivewireDatatable
{

    public $model = Drive::class;

    public function builder()
    {
        return Drive::query();
    }

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('name')
                ->searchable(),

            Column::name('value')
                ->searchable(),

            Column::callback(['id'], function ($id) {
                return view('drives.actions', ['id' => $id]);
            })
        ];
    }
}

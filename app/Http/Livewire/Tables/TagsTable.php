<?php

namespace App\Http\Livewire\Tables;

use App\Models\Tag;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class TagsTable extends LivewireDatatable
{
    public function builder()
    {
        return Tag::query()
            ->with(['drive'])
            ->withCount('children');
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->linkTo('tags'),

            Column::name('name')
                ->searchable(),

            NumberColumn::name('children.id:count')
                ->label('Children Count'),

            Column::name('drive.name')
                ->label('Drive'),

            Column::name('created_at')
                ->label('Created At')
                ->callback(['created_at'], function ($created_at) {
                    return jdate($created_at);
                }),

            Column::callback(['id'], function ($id) {
                return view('tags.actions', ['id' => $id]);
            })
        ];
    }
}

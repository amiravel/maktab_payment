<?php

namespace App\Http\Livewire;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class RefundTable extends DataTableComponent
{

    public array $filters = [
        'seen' => 'unread',
    ];

    public function filters(): array
    {
        return [
            'seen' => Filter::make('Seen')
                ->select([
                    '' => 'Any',
                    'read' => 'Yes',
                    'unread' => 'No'
                ])
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), "id"),
            Column::make(__('Name'), "name")->searchable(),
            Column::make(__('Email'), "email")->searchable(),
            Column::make(__('Mobile'), "mobile")->searchable(),

            Column::make(__('Created At'), 'created_at')->format(fn($value) => jdate($value)),
        ];
    }

    public function query(): Builder
    {
        return Refund::query()->latest()
            ->when($this->getFilter('seen'), fn(Builder $query, $seen) => $query->where('seen', $seen === 'read'));
    }

    public function getTableRowUrl($row): string
    {
        return route('refunds.show', $row);
    }

    public function setTableRowClass(Refund $row): ?string
    {
        return $row->seen == false ? 'font-black' : '';
    }
}

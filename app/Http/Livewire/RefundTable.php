<?php

namespace App\Http\Livewire;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class RefundTable extends DataTableComponent
{
    protected $model = Refund::class;

    public function configure(): void
    {
        $this->setPrimaryKey('uuid');
        $this->setTdAttributes(function ($column, $row, $columnIndex, $rowIndex) {
            if (!$row->seen) {
                return [
                    'default' => true,
                    'class' => 'font-black',
                ];
            }

            return ['default' => true];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), "id"),
            Column::make(__('UUID'), "uuid")
                ->format(
                    fn ($value, $row, Column $column) => "<p class='w-16 truncate ...'>" . $row->uuid . "</p>"
                )->html(),
            Column::make(__('Name'), "name")->searchable(),
            Column::make(__('Email'), "email")->searchable(),
            Column::make(__('Mobile'), "mobile")->searchable(),

            Column::make(__('Created At'), 'created_at')->format(fn ($value) => jdate($value)),

            BooleanColumn::make(__('Read'), 'seen'),

            ButtonGroupColumn::make(__('Actions'))
                ->buttons([
                    LinkColumn::make('Show')
                        ->title(fn ($row) => __('Show'))
                        ->location(fn ($row) => route('refunds.show', $row->uuid))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'bg-blue-500 mx-2 text-white px-2 py-1 rounded font-medium hover:bg-blue-600 transition duration-200 each-in-out',
                            ];
                        }),
                ]),
        ];
    }

    public function builder(): Builder
    {
        return Refund::query()->latest();
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CycleTable extends DataTableComponent
{
    protected $model = Cycle::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        $number_format = fn ($value) => number_format($value);

        return [
            Column::make(__('ID'), 'id'),

            Column::make(__('First'), 'first')->format($number_format),
            Column::make(__('Center'), 'center')->format($number_format),
            Column::make(__('Second Center'), 'second_center')->format($number_format),
            Column::make(__('End'), 'end')->format($number_format),

            Column::make(__('Percentage'), 'percentage'),

            Column::make(__('Current Max'), 'max')->label(fn ($row, Column $column) => $number_format($row->max) . "T"),
            Column::make("تعداد پرداختی‌ها", 'payments_count')->label(fn ($row, Column $column) => $row->payments_count),

            Column::make("مجموع پرداخت", 'payments_sum_amount')->label(fn ($row, Column $column) => $number_format($row->payments_sum_amount) . "T"),

            Column::make(__('Created At'), 'created_at')->format(fn ($value) => jdate($value)),
            Column::make(__('Ended At'), 'ended_at')->format(fn ($value) => $value ? jdate($value) : ''),
        ];
    }

    public function builder(): Builder
    {
        return Cycle::query()->latest()
            ->withCount('payments')
            ->withSum('payments', 'amount');
    }
}

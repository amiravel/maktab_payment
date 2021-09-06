<?php

namespace App\Http\Livewire;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CycleTable extends DataTableComponent
{

    public function columns(): array
    {
        $number_format = fn($value) => number_format($value);

        return [
            Column::make(__('ID'), 'id'),

            Column::make(__('First'), 'first')
                ->format($number_format),
            Column::make(__('Center'), 'center')
                ->format($number_format),
            Column::make(__('End'), 'end')
                ->format($number_format),

            Column::make(__('Percentage'), 'percentage'),

            Column::make("تعداد پرداختی‌ها", 'payments_count')
                ->format($number_format),

            Column::make("مجموع پرداخت", 'payments_sum_amount')
                ->format($number_format),

            Column::make('درگاه', 'drive'),

            Column::make(__('Created At'), 'created_at')
                ->format(fn($value) => jdate($value)),
            Column::make(__('Ended At'), 'ended_at')
                ->format(fn($value) => $value ? jdate($value) : ''),
        ];
    }

    public function query(): Builder
    {
        return Cycle::query()->latest()
            ->withCount('payments')
            ->withSum('payments', 'amount');
    }

    public function getTableRowUrl($row): string
    {
        return route('cycles.show', $row);
    }
}

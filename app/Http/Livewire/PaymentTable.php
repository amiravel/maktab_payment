<?php

namespace App\Http\Livewire;

use App\Exports\PaymentsExport;
use App\Models\Drive;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class PaymentTable extends DataTableComponent
{

    public bool $columnSelect = true;

    public array $bulkActions = [
        'export' => 'خروجی',
    ];

    public function filters(): array
    {
        return [
            'status' => Filter::make('Status')
                ->select([
                    '' => 'ALL',
                    'created' => 'Created',
                    'successful' => 'Successful',
                    'error' => 'Error'
                ]),
            'from' => Filter::make('From')
                ->date(),
            'to' => Filter::make('To')
                ->date()
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id'),
            Column::make(__('Name'), 'name')->searchable(),
            Column::make(__('Mobile'), 'mobile')->searchable(),
            Column::make(__('Email'), 'email')->searchable(),
            Column::make(__('Amount'), 'amount')
                ->format(fn($value) => number_format($value) . "T"),
            Column::make(__('RefID'), 'ReferenceID'),
            Column::make(__('Drive'), 'drive')
                ->format(fn(Drive $drive) => "<img class='w-8 h-8 mx-auto' alt='" . optional($drive)->name . "' src='" . asset("svg/drives/$drive->value.png") . "' />")
                ->asHtml(),
            Column::make(__('Tags'), 'tags')
                ->format(fn($value) => $value->implode('name', ', ')),
            Column::make(__('Created At'), 'created_at')->format(fn($value) => jdate($value)),
            Column::make(__('Actions'))
                ->format(fn($value, $column, $row) => view('payments.actions',)->withModel($row))
        ];
    }

    public function query(): Builder
    {
        return Payment::query()->latest()
            ->with(['tags'])
            ->when($this->getFilter('status'), fn(Builder $query, $search) => $query->scopes($search))
            ->when($this->getFilter('from'), fn(Builder $query, $search) => $query->whereDate('created_at', '>=', $search))
            ->when($this->getFilter('to'), fn(Builder $query, $search) => $query->whereDate('created_at', '<=', $search));
    }

    public function setTableRowClass(Payment $row): ?string
    {
        return !$row->read ? 'font-bold' : '';
    }

    public function changeSeen($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'read' => !$payment->read
        ]);
    }

    public function export()
    {
        $now = jdate();

        if ($this->selectedRowsQuery->count() > 0) {
            return (new PaymentsExport($this->selectedRowsQuery->get()))->download("payments_$now.xlsx");
        }
    }
}

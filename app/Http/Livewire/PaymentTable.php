<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use App\Exports\PaymentsExport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class PaymentTable extends DataTableComponent
{

    protected $model = Payment::class;

    public function bulkActions(): array
    {
        return [
            'read' => 'Read',
            'unread' => 'Unread',
            'export' => 'Export',
        ];
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPerPage(25);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setFilterLayoutSlideDown();

        $this->setTdAttributes(function ($column, $row, $columnIndex, $rowIndex) {
            if (!$row->read) {
                return [
                    'default' => true,
                    'class' => 'font-black',
                ];
            }

            return ['default' => true];
        });

        $this->setHideBulkActionsWhenEmptyEnabled();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('read')
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('read', true);
                    } elseif ($value === '0') {
                        $builder->where('read', false);
                    }
                }),
            SelectFilter::make('status')
                ->options([
                    '' => 'All',
                    'created' => 'Created',
                    'successful' => 'Successful',
                    'error' => 'Error',
                ]),
            DateFilter::make('Created From', 'from'),
            DateFilter::make('Created To', 'to'),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id'),
            Column::make(__('Name'), 'name')->searchable(),
            Column::make(__('Mobile'), 'mobile')->searchable(),
            Column::make(__('Email'), 'email')->searchable(),

            Column::make(__('Amount'), 'amount')->format(fn ($value) => number_format($value) . "T"),

            Column::make(__('Tags'), 'Tags')
                ->label(fn ($row) => $row->tags->pluck('name')->implode(', '))
                ->collapseOnTablet(),

            Column::make(__('Status'), 'status')
                ->label(fn ($row, Column $column) => $row->status('successful') ? '<span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">موفق</span>' : '<span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">خطا</span>')
                ->html(),

            BooleanColumn::make(__('Read'), 'read'),

            Column::make(__('Created At'), 'created_at')->format(fn ($value) => jdate($value)),
            ButtonGroupColumn::make(__('Actions'))->buttons([
                LinkColumn::make('Show')
                    ->title(fn ($row) => __('Show'))
                    ->location(fn ($row) => route('payments.show', $row))
                    ->attributes(function ($row) {
                        return [
                            'class' => 'bg-blue-500 mx-2 text-white px-2 py-1 rounded font-medium hover:bg-blue-600 transition duration-200 each-in-out',
                        ];
                    }),
            ])
        ];
    }

    public function builder(): Builder
    {
        return Payment::query()->latest()
            ->with(['tags'])
            ->when($this->getAppliedFilterWithValue('status'), fn (Builder $query, $status) => $query->scopes($status))
            ->when($this->getAppliedFilterWithValue('from'), fn ($query, $from) => $query->whereDate('created_at', '>=', $from))
            ->when($this->getAppliedFilterWithValue('to'), fn ($query, $to) => $query->whereDate('created_at', '<=', $to));
    }

    public function read()
    {
        Payment::whereIn('id', $this->getSelected())->update(['read' => true]);
        $this->clearSelected();
    }

    public function unread()
    {
        Payment::whereIn('id', $this->getSelected())->update(['read' => false]);
        $this->clearSelected();
    }

    public function export()
    {
        $now = jdate();
        $payments = $this->getSelected();

        $this->clearSelected();

        return (new PaymentsExport($payments))->download("payments_$now.xlsx");
    }
}

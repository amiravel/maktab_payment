<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class PaymentsExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings, WithColumnFormatting, WithMapping, WithEvents
{

    use Exportable;

    public $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Payment::with(['drive'])->findMany($this->payments);
    }

    public function headings(): array
    {
        return [
            '#',
            'نام و نام‌خانوادگی',
            'ایمیل',
            'شماره همراه',
            'توضیحات',
            'مبلغ',
            'شماره ارجاع',
            'درگاه پرداخت',
            'وضعیت',
            'تاریخ پرداخت (شمسی)',
            'تاریخ پرداخت (میلادی)',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->email,
            $row->mobile,
            $row->description,
            $row->amount,
            $row->referenceID,
            $row->drive->name,
            $row->referenceID ? "موفق" : "ناموفق",
            jdate($row->created_at),
            $row->created_at,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'F' => "#,##0",
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}

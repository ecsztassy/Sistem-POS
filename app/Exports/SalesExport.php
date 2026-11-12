<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class SalesExport extends StringValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private Builder $builder) {}

    public function query()
    {
        return $this->builder->with('details')->orderBy('created_at');
    }

    public function headings(): array
    {
        return ['Invoice', 'Tanggal', 'Kasir', 'Total (Rp)', 'Bayar (Rp)', 'Kembalian (Rp)', 'Laba (Rp)'];
    }

    public function map($row): array
    {
        return [$row->invoice_code, $row->created_at->format('Y-m-d H:i:s'), $row->user->name, $row->total_price, $row->pay_amount, $row->change_amount, $row->details->sum(fn ($detail) => ($detail->price - $detail->buy_price) * $detail->qty)];
    }

    public function bindValue(Cell $cell, $value): bool
    {
        if (is_int($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}

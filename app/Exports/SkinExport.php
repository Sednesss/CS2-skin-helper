<?php

namespace App\Exports;

use App\Models\Skin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use PhpOffice\PhpSpreadsheet\Shared\Date;

class SkinExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Skin::all();
    }

    public function headings(): array
    {
        return [
            'description',
            'pattern',
            'float',
            // 'created_at',
            // 'updated_at',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->description,
            $invoice->pattern,
            $invoice->float,
            // Date::dateTimeToExcel($invoice->created_at),
            // Date::dateTimeToExcel($invoice->updated_at),
        ];
    }
}

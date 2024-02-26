<?php

namespace App\Exports;

use App\Models\Skin;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use PhpOffice\PhpSpreadsheet\Shared\Date;

class SkinExport implements FromCollection, WithHeadings, WithMapping
{
    protected $skins;

    public function __construct(Collection $skins)
    {
        $this->skins = $skins;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->skins;
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

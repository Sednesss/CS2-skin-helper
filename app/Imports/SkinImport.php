<?php

namespace App\Imports;

use App\Models\Skin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkinImport implements ToModel, WithHeadingRow
{
    protected $gameItemId;

    public function __construct(int $gameItemId)
    {
        $this->gameItemId = $gameItemId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Skin([
            'game_item_id' => $this->gameItemId,
            'description' => $row['description'],
            'pattern' => $row['pattern'],
            'float' => $row['float'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}

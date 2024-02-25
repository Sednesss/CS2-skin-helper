<?php

namespace App\Imports;

use App\Models\Skin;
use Maatwebsite\Excel\Concerns\ToModel;

class SkinImport implements ToModel
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
            'description' => $row[0],
            'pattern' => $row[1],
            'float' => $row[2],
        ]);
    }
}

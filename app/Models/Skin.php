<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skin extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'skins';

    protected $fillable = [
        'game_item_id',
        'description',
        'pattern',
        'float',
    ];

    public static $rules = [
        'float' => 'numeric|min:0|max:1',
    ];

    public function gameItem(): BelongsTo
    {
        return $this->belongsTo(GameItem::class, 'game_item_id');
    }
}

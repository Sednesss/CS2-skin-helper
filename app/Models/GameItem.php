<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameItem extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'game_items';

    protected $fillable = [
        'title',
        'description',
        'image_preview_path',
    ];

    public function skins(): HasMany
    {
        return $this->hasMany(Skin::class, 'game_item_id');
    }
}

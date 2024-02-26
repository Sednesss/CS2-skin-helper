<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameItem extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    
    public $timestamps = true;

    protected $table = 'game_items';

    protected $fillable = [
        'title',
        'description',
        'image_preview_path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($gameItem) {
            Skin::where('game_item_id', $gameItem->id)->delete();
        });
    }

    public function skins(): HasMany
    {
        return $this->hasMany(Skin::class, 'game_item_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lot extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'lots';

    protected $fillable = [
        'title',
        'description',
        'image_preview_path',
    ];

    public function skins(): HasMany
    {
        return $this->hasMany(Skin::class, 'lot_id');
    }
}

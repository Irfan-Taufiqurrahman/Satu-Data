<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainData extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_main',
        'title_main',
    ];

    public function Thematic()
    {
        return $this->hasMany(ThematicData::class);
    }
}

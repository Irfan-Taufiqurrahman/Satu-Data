<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThematicData extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_thematic',
        'title_thematic',
        'name_opd',
    ];

    public function mainData()
    {
        return $this->belongsTo(MainData::class);
    }
}

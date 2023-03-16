<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicData extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_topic',
        'indicator',
        'formula',
        'code_thematic'
    ];

    public function ThematicData()
    {
        return $this->belongsTo(ThematicData::class);
    }
}

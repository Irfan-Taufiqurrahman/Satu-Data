<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicData extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_topic',
        'kinerja_utama',
        'sumber_data',
        'penanggungjawab',
        'thematic_code',
    ];

    public function ThematicData()
    {
        return $this->belongsTo(ThematicData::class, 'thematic_code', 'code_topic');
    }

    // public function setCustomCode(string $code_thematic): self
    // {
    //     // return $this->MainData->code_main . '.' . $this->code_thematic;
    //     $this->code_main = $code_thematic;

    //     return $this;
    // }
    public function setCustomIdAttribute($value)
    {
        // $thematicCode = $this->ThematicData->code_thematic;
        // $this->attributes['custom_id'] = $thematicCode . '.' . $value;
        $thematicCode = $this->attributes['code_thematic'];
        $this->attributes['code_topic'] = $thematicCode . '.' . $value;
    }
}

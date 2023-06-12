<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTopicData extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_subtopic',
        'indikator_kinerja_utama',
        'formula',
        'topic_code',
    ];

    public function SubTopic()
    {
        return $this->belongsTo(ThematicData::class, 'topic_code', 'code_subtopic');
    }

    public function setCustomIdAttribute($value)
    {
        // $thematicCode = $this->ThematicData->code_thematic;
        // $this->attributes['custom_id'] = $thematicCode . '.' . $value;
        $topicCode = $this->attributes['code_topic'];
        $this->attributes['code_subtopic'] = $topicCode . '.' . $value;
    }
}

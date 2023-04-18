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
        'main_code',
    ];

    public function mainData()
    {
        return $this->belongsTo(MainData::class, 'main_code', 'code_thematic');
    }

    // public function setCustomCode(string $code_thematic): self
    // {
    //     // return $this->MainData->code_main . '.' . $this->code_thematic;
    //     $this->code_main = $code_thematic;

    //     return $this;
    // }

    // Add a mutator for the custom ID
    public function setCustomIdAttribute($value)
    {
        // $mainCode = $this->mainData->code_main;
        // $this->attributes['custom_id'] = $mainCode . '.' . $value;
        $mainCode = $this->attributes['code_main'];
        $this->attributes['code_thematic'] = $mainCode . '.' . $value;
    }

    public function getCode(): ?string
    {
        return $this->code_thematic;
    }

    public function setCode(string $code_thematic): self
    {
        $this->code_thematic = $code_thematic;

        return $this;
    }
}

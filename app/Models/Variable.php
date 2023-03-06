<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $table = "variables";
    protected $primaryKey = "varId";

    protected $fillable = [
        'name',
        'id_dataset',
        'data',
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class, 'datasetId');
    }

    public function valuesData()
    {
        return $this->hasMany(value::class, 'valueId');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDataset(): ?Dataset
    {
        return $this->id_dataset;
    }

    public function setDataset(string $datasetId): self
    {
        $this->id_dataset = $datasetId;

        return $this;
    }
}

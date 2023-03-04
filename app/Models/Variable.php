<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $table = "variable_table";
    protected $primaryKey = "varId";

    // protected $fillable = [
    //     'name',
    //     'dataset_id',
    //     'data',
    // ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class, 'datasetId');
    }

    public function valuesData()
    {
        return $this->hasMany(value::class, 'valueId');
    }
}

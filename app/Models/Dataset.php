<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $table = "dataset_table";
    protected $primaryKey = "datasetId";
    protected $fillable = [
        'title',
        'variables',
        'values',
        'name_excel',
        'description',
    ];

    public function variablesData()
    {
        return $this->hasMany(Variable::class, "datasetId");
    }
}

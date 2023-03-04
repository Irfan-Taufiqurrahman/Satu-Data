<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class value extends Model
{
    use HasFactory;

    protected $table = "value_table";
    protected $primaryKey = "valueId";
    // protected $fillable = [
    //     'dataset',
    //     'variables',
    //     'content',
    //     'row_id',
    // ];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variableId');
    }
}

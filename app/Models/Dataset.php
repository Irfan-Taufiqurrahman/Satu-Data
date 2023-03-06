<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $table = "datasets";
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
        return $this->hasMany(Variable::class, 'datasetId');
    }

    public function getLinkAPI(): ?string
    {
        return $this->link_API;
    }

    public function setLinkAPI(string $link_API): self
    {
        $this->link_API = $link_API;

        return $this;
    }
}

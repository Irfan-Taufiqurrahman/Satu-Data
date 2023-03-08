<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class value extends Model
{
    use HasFactory;

    protected $table = "values";
    protected $primaryKey = "value_id";
    protected $fillable = [
        'id_dataset',
        'id_variable',
        'content',
        'row_id',
    ];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'id_variable', 'var_id');
    }

    public function getDataset(): ?Dataset
    {
        return $this->id_dataset;
    }

    public function setDataset(int $dataset): self
    {
        $this->id_dataset = $dataset;

        return $this;
    }

    public function getVar(): ?Variable
    {
        return $this->id_variable;
    }

    public function setVar(string $var): self
    {
        $this->id_variable = $var;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRowId(): ?int
    {
        return $this->row_id;
    }

    public function setRowId(int $row_id): self
    {
        $this->row_id = $row_id;

        return $this;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'name',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function standards()
    {
        return $this->hasMany(Standard::class);
    }
}

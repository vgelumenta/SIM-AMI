<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;

    protected $fillable = [
        'standard_id',
        'name',
    ];

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}

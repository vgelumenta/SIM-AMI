<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'competency_id',
        'code',
        'assessment',
        'entry',
        'rate_option',
        'disable_text',
        'info',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function formAudits()
    {
        return $this->hasMany(FormAudit::class);
    }
}

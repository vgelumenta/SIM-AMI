<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'competency_id',
        'assessment',
        'code',
        'entry',
        'rate_option',
        'link_info',
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

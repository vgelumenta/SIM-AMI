<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'unit_id',
        'stage_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function formTime()
    {
        return $this->hasOne(FormTime::class);
    }

    public function formAccesses()
    {
        return $this->hasMany(FormAccess::class);
    }

    public function formAudits()
    {
        return $this->hasMany(FormAudit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'indicator_id',
        'submission_status',
        'validation',
        'link',
        'assessment_status',
        'description',
        'feedback',
        'comment',
        'validation_status',
        'conclusion',
        'planning',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }
}

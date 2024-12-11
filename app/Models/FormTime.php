<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'submission_time',
        'submission_deadline',
        'submission_extended',
        'assessment_time',
        'assessment_deadline',
        'assessment_extended',
        'feedback_time',
        'feedback_deadline',
        'feedback_extended',
        'verification_time',
        'verification_deadline',
        'verification_extended',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}

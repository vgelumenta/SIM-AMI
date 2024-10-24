<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'submission',
        'submission_deadline',
        'submission_extended',
        'assessment',
        'assessment_deadline',
        'assessment_extended',
        'feedback',
        'feedback_deadline',
        'feedback_extended',
        'verification',
        'verification_deadline',
        'verification_extended',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}

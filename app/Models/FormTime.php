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
        'validation_time',
        'validation_deadline',
        'validation_extended',
        'meeting_time',
        'meeting_deadline',
        'meeting_extended',
        'planning_time',
        'planning_deadline',
        'planning_extended',
        'signing_time',
        'signing_deadline',
        'signing_extended',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}

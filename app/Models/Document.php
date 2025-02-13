<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}

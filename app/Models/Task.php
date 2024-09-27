<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'duration',
        'difficulty',
    ];
    protected $casts = [
        'name' => 'string',
        'duration' => 'integer',
        'difficulty' => 'float',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}

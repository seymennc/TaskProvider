<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $table = 'developers';
    protected $fillable = [
        'name',
        'hourly_capacity',
        'difficulty_multiplier',
        ];
    protected $casts = [
        'name' => 'string',
        'hourly_capacity' => 'integer',
        'difficulty_multiplier' => 'float',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function taskAssignments()
    {
        return $this->hasMany(TaskAssignment::class, 'developer_id', 'id');
    }
}

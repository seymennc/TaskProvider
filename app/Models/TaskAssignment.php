<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    use HasFactory;

    protected $table = 'task_assignments';
    protected $fillable = [
        'task_id',
        'developer_id',
        'hours_allocated',
    ];
    protected $casts = [
        'task_id' => 'integer',
        'developer_id' => 'integer',
        'hours_allocated' => 'array',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function task()
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
    }

    public function developer()
    {
        return $this->hasOne(Developer::class, 'id', 'developer_id');
    }
}

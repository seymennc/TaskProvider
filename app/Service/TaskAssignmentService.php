<?php

namespace App\Service;

use App\Models\Developer;
use App\Models\Task;
use App\Models\TaskAssignment;

class TaskAssignmentService
{
    public function assignTask()
    {
        $tasks = Task::all();
        $developers = Developer::all();
        $task_list = [];

        foreach ($tasks as $task) {
            $duration_default = $task->duration * $task->difficulty;

            foreach ($developers as $developer) {
                $handle_hour = $duration_default / $developer->difficulty_multiplier;

                if ($handle_hour > 45) {
                    $week = floor($handle_hour / 45);
                    $day = floor(($handle_hour % 45) / 9);
                    $hour = $handle_hour % 9;
                    $handle_hour_text = ['week' => $week, 'day' => $day, 'hour' => round($hour)];
                } elseif ($handle_hour > 9) {
                    $day = floor($handle_hour / 9);
                    $hour = $handle_hour % 9;
                    $handle_hour_text = ['day' => $day, 'hour' => round($hour)];
                } else {
                    $handle_hour_text = ['hour' => round($handle_hour)];
                }

                $task_list[$task->id][] = [
                    'developer_name' => $developer->name,
                    'task_name' => $task->name,
                    'handle_hour' => $handle_hour,
                    'handle_hour_text' => $handle_hour_text,
                ];
                TaskAssignment::updateOrCreate([
                    'task_id' => $task->id,
                    'developer_id' => $developer->id,
                    'hours_allocated' => $handle_hour_text,
                ]);
            }
        }
        return '';
    }
}

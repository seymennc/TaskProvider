<?php

namespace App\Helpers;

use App\Models\Developer;
use App\Models\Task;
use Illuminate\Support\Carbon;

class CalculatorHelper
{

    public function calculate()
    {
        $tasks = Task::all();
        $developers = Developer::all();
        $task_list = [];

        foreach ($tasks as $task) {
            $duration_default = $task->duration * $task->difficulty;

            foreach ($developers as $developer) {
                $handle_hour = $duration_default / $developer->difficulty_multiplier;

                if ($handle_hour > 45) {
                    $hafta = floor($handle_hour / 45);
                    $day = floor(($handle_hour % 45) / 9);
                    $hour = $handle_hour % 9;
                    $handle_hour_text = "$hafta hafta $day gün $hour saat";
                } elseif ($handle_hour > 9) {
                    $day = floor($handle_hour / 9);
                    $hour = $handle_hour % 9;
                    $handle_hour_text = "$day gün $hour saat";
                } else {
                    $handle_hour_text = "$handle_hour saat";
                }

                $task_list[$task->id][] = [
                    'developer_name' => $developer->name,
                    'task_name' => $task->task_name,
                    'handle_hour' => $handle_hour,
                    'handle_hour_text' => $handle_hour_text,
                ];
            }
        }

        dd($task_list);
    }
}

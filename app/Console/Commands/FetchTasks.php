<?php

namespace App\Console\Commands;

use App\Events\TaskFetched;
use App\Models\Task;
use App\Service\Providers\ProviderService;
use App\Service\TaskAssignmentService;
use Database\Factories\TaskProviderFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class FetchTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch tasks from different providers and save them to the database';

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function handle(): void
    {
        $service = new ProviderService();
        $providerData = $service->getProviderData();

        foreach ($providerData as $task) {
            foreach ($task['data'] as $taskData){
                if(!isset($taskData['id'], $taskData['title'], $taskData['time'], $taskData['level'])){
                    $this->error('Task data is not valid!');
                    continue;
                }

                Task::updateOrCreate([
                    'name' => $taskData['title'],
                    'duration' => $taskData['time'],
                    'difficulty' => $taskData['level'],
                ]);
            }
        }

        $this->info('Tasks fetched successfully!');

        $taskAssignmentService = new TaskAssignmentService();
        $weekCount = $taskAssignmentService->assignTask(); // Pass the provider if needed

        $this->info("Tasks have been assigned over " . print_r($weekCount) . " week(s).");
    }

    /**
     * Gets all provider names in the Service/Providers directory.
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function getProvidersFromDirectory(): array
    {
        $providers = [];

        $providerPath = app_path('Service/Providers');

        foreach (File::files($providerPath) as $file) {
            $className = 'App\\Service\\Providers\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);

            $reflectionClass = new ReflectionClass($className);

            if ($reflectionClass->implementsInterface(\App\Service\ProviderServiceInterface::class)) {
                $providerName = strtolower($reflectionClass->getShortName());
                $providers[] = strtolower(substr($providerName, 0, -7)); // Remove 'Service' and convert to lowercase
            }
        }

        return $providers;
    }
}

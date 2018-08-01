<?php

namespace App\Console\Commands;

use Event;
use App\Events;
use App\Project;
use App\Exceptions;
use Illuminate\Console\Command;
use App\Services\ProjectService;
use App\Repositories\ProjectRepository;

class CleanProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ProjectRepository $projectRepository, ProjectService $projectService)
    {
        $projects = $projectRepository->waitingForCleaning();

        if (! $projects['data']) {
            return $this->info('No projects to clean');
        }

        foreach ($projects['data'] as $project) {
                
            $project = $projectService->clean($project);

            $this->ready($project);
        }
    }

    /**
     * @param  array  $project
     * @return void
     */
    protected function ready(array $project)
    {
        $format = "#%s %s\%s has been cleaned !";

        $params = [
            $project['id'], 
            $project['username'], 
            $project['repository'], 
            $project['hash']
        ];

        $this->info(vsprintf($format, $params));
    }
}

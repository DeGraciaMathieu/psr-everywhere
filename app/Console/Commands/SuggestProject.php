<?php

namespace App\Console\Commands;

use Event;
use App\Events;
use App\Project;
use Illuminate\Console\Command;
use App\Services\ProjectService;
use App\Repositories\ProjectRepository;

class SuggestProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:suggest';

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
        $projects = $projectRepository->waitingForSuggestion();

        if (! $projects['data']) {
            return $this->info('No project to suggest');
        }

        foreach ($projects['data'] as $project) {

            $projectService->suggest($project);

            $this->ready($project); 
        }
    }

    /**
     * @param  array  $project
     * @return void
     */
    protected function ready(array $project)
    {
        $format = "#%s %s\%s has been suggested in %s !";

        $params = [
            $project['id'], 
            $project['username'], 
            $project['repository'], 
            $project['hash']
        ];

        $this->info(vsprintf($format, $params));
    }     
}

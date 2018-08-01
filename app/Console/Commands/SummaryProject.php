<?php

namespace App\Console\Commands;

use App\Project;
use Illuminate\Console\Command;
use App\Services\ProjectService;
use App\Repositories\ProjectRepository;

class SummaryProjects extends Command
{
    protected $projectRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:summary {id?} {--option=}';

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
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = $this->option('option');

        $id = $this->argument('id');

        switch ($option) {
            case 'show':
                return $this->showProject($id);
                break;
            
            default:
                return $this->default();
                break;
        }
    }

    /**
     * @param  int $id
     * @return no idea
     */
    protected function showProject(int $id)
    {
        $project = $this->projectRepository->find($id);

        $this->displayLines($project['data']);
    }

    /**
     * @return no idea
     */
    protected function default()
    {
        $headers = ['id', 'url', 'created_at', 'prepared_at', 'standardised_at', 'suggested_at', 'cleaned_at'];

        $projects = $this->projectRepository->all($headers);

        $projects = array_map(function($project){

            return [
                'id' => $project['id'],
                'url' => $project['url'],
                'created_at' => $project['created_at'],
                'prepared_at' => $project['prepared_at'],
                'standardised_at' => $project['standardised_at'],
                'suggested_at' => $project['suggested_at'],
                'cleaned_at' => $project['cleaned_at'],
            ];
        }, $projects['data']);

        $this->displayTable($headers, $projects);
    }    

    /**
     * @param  array $headers
     * @param  array $data
     * @return no idea
     */
    protected function displayTable(array $headers, array $data)
    {
        $this->table($headers, $data);
    }

    /**
     * @param  string $lines
     * @return [type]
     */
    protected function displayLines(string $lines)
    {
        foreach ($lines as $key => $value) {
            $this->info($key);
            $this->line($value ?? 'null');
        }
    }
}

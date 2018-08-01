<?php

namespace App\Console\Commands;

use Exception;
use App\Project;
use App\Exceptions;
use Spatie\Regex\Regex;
use Illuminate\Console\Command;
use App\Services\ProjectService;
use App\Managers\GithubApi\GithubApiManager;

class InitProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:init {fullName}';

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
    public function handle(ProjectService $projectService)
    {
        try {
            
            $fullName = $this->argument('fullName');

            list($username, $repository) = $this->parse($fullName);

            $project = $projectService->init($username, $repository);

            $this->ready($project['data']);

        } catch (Exceptions\UnableToParseFullname $e) {
            $this->error('Unable to parse the fullname, you must respect the format {username}/{repository}');
        } catch (Exceptions\ProjectAlreadyInitialised $e) {
            $this->error('The project is already being processed');   
        }     
    }

    /**
     * @param  string $fullName
     * @throws \App\Exceptions\UnableToParseFullname
     * @return array
     */
    protected function parse($fullName) :array
    {
        $result = Regex::match('#(http|https)://github.com/(.*)\/(.*)#', $fullName);

        throw_unless($result->hasMatch(), Exceptions\UnableToParseFullname::class);

        return [
            $result->group(2),
            $result->group(3)
        ];
    }

    /**
     * @param  array  $project
     * @return void
     */
    protected function ready(array $project)
    {
        $format = "#%s %s\%s has been saved !";

        $params = [
            $project['id'], 
            $project['username'], 
            $project['repository']
        ];

        $this->info(vsprintf($format, $params));
    }    
}

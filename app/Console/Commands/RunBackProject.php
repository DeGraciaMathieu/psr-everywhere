<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProjectService;
use App\Repositories\ProjectRepository;

class RunBackProject extends Command
{
    protected $projectRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:run-back {id}';

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
        $id = $this->argument('id');

        // delete fork
        // delete local
        // delete line
    }
}

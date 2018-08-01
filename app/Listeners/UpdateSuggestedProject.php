<?php

namespace App\Listeners;

use App\Events\ProjectSuggested;
use App\Repositories\ProjectRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSuggestedProject
{
    protected $projectRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProjectSuggested $event)
    {
        $params = [
            'suggested_at' => date('Y-m-d H:i:s'),
        ];

        $this->projectRepository->update($params, $event->project['id']);
    }
}

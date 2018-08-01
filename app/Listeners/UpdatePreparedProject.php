<?php

namespace App\Listeners;

use App\Events\ProjectPrepared;
use App\Repositories\ProjectRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePreparedProject
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
    public function handle(ProjectPrepared $event)
    {
        $params = [
            'prepared_at' => date('Y-m-d H:i:s'),
            'hash' => $event->project['hash'],
        ];

        $this->projectRepository->update($params, $event->project['id']);
    }
}

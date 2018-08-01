<?php

namespace App\Services;

use Cz\Git\GitRepository;

class GitService
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param  string $name
     * @param  string $path
     * @return void
     */
    public function clone(string $name, string $path)
    {
        GitRepository::cloneRepository($name, $path);
    }

    /**
     * @param  string $path
     * @return boolean
     */
    public function hasChanges(string $path) :bool
    {
        $repository = new GitRepository($path);

        return $repository->hasChanges();
    }

    public function suggest(string $path, string $forkedRepository)
    {
        $repository = new GitRepository($path);

        $repository->addAllChanges();

        $repository->commit($this->config['commit_message']);

        $forkUrl = sprintf($this->config['fork_url'], 
            $this->config['bot_username'], 
            $this->config['bot_password'], 
            $this->config['bot_username'], 
            $forkedRepository
        );

        $repository->push(NULL, ['--repo' => $forkUrl]);
    }
}

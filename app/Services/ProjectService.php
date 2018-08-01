<?php

namespace App\Services;

use Hash;
use Event;
use App\Events;
use App\Project;
use App\Exceptions;
use App\Repositories\ProjectRepository;
use App\Managers\GithubApi\GithubApiManager;

class ProjectService
{
    protected $folderService;
    protected $gitService;
    protected $standardizeService;
    protected $githubApiManager;

    public function __construct(FolderService $folderService, GitService $gitService, StandardizeService $standardizeService, ProjectRepository $projectRepository)
    {
        $this->folderService = $folderService;
        $this->gitService = $gitService;
        $this->standardizeService = $standardizeService;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param  string $username  
     * @param  string $repository
     * @throws \App\Exceptions\ProjectAlreadyInitialised
     * @return array           
     */
    public function init(string $username, string $repository) :array
    {
        $projectAlreadyInitialised = $this->projectRepository->findByCredentials($username, $repository);

        throw_if($projectAlreadyInitialised['data'], Exceptions\ProjectAlreadyInitialised::class);

        $repository = app(GithubApiManager::class)->show($username, $repository);

        $params = [
            'username' => $repository->getUsername(),
            'repository' => $repository->getRepository(),
            'url' => $repository->getHtmlUrl(),
            'default_branch' => $repository->getDefaultBranch(),
            'hash' => str_random(40),
        ];

        return $this->projectRepository->create($params);
    }

    /**
     * @param  array $project  
     * @throws \App\Exceptions\Exceptions\GithubApiManager
     * @return array
     */
    public function prepare(array $project) :array
    {
        $url = app(GithubApiManager::class)->fork($project['username'], $project['repository']);

        $pathToClone = $this->folderService->create($project['hash']);

        $this->gitService->clone($url, $pathToClone);

        Event::fire(new Events\ProjectPrepared($project));

        return $project;
    }

    /**
     * @param  array $project  
     * @return array
     */
    public function standardise(array $project) :array
    {
        $folderPath = $this->folderService->getFolderPath($project['hash']);

        $this->standardizeService->process($folderPath);

        Event::fire(new Events\ProjectStandardised($project));     
        
        return $project;   
    }

    /**
     * @param  array $project  
     * @return array
     */
    public function suggest(array $project)
    {
        $folderPath = $this->folderService->getFolderPath($project['hash']);

        if ($this->gitService->hasChanges($folderPath)) {

            $this->gitService->suggest($folderPath, $project['repository']);

            app(GithubApiManager::class)->pullRequest($project);
        }

        Event::fire(new Events\ProjectSuggested($project));

        return $project;         
    }

    /**
     * @param  array $project  
     * @return array
     */
    public function clean(array $project)
    {
        $this->folderService->deleteFolder($project['hash']);

        app(GithubApiManager::class)->deleteFork($project);

        Event::fire(new Events\ProjectCleaned($project));

        return $project;         
    }
}

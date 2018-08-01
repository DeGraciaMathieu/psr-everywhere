<?php

namespace App\Managers\GithubApi\Drivers;

use App\Entities;
use App\Exceptions;
use Github\Client as ClientApi;
use App\Managers\GithubApi\Contracts\Driver;
use Github\HttpClient\Plugin\GithubExceptionThrower;

class Client implements Driver {

    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = $this->setClient();
    }

    /**
     * @param  string $username
     * @param  string $repository
     * @return \App\Entities\Repository
     */
    public function show(string $username, string $repository) :Entities\Repository
    {
        $result = $this->client->api('repo')->show($username, $repository);

        return new Entities\Repository($result);
    }

    /**
     * @return array
     */
    public function repositories() :array
    {
        $results = $this->client->api('me')->repositories();

        return array_map(function($result){
            return new Entities\Repository($result);
        }, $results);
    }

    /**
     * @param  string $username
     * @param  string $repository
     * @throws \App\Exceptions\GithubApiManager
     * @return string
     */
    public function fork(string $username, string $repository) :string
    {
        $repositories = $this->repositories();

        $fullName = $username . '/' . $repository;

        array_map(function($repository) use($fullName) {

            $alreadyFork = ($repository->getFullName() == $fullName);

            throw_if($alreadyFork, new Exceptions\GithubApiManager("already fork"));

        }, $repositories);

        $this->client->api('repo')->forks()->create($username, $repository);

        return sprintf($this->config['bot_repositories_url'], $this->config['bot_username'], $repository);
    }

    /**
     * @param  array
     * @return void
     */
    public function pullRequest(array $project)
    {
        $params = $this->config['pull_request'] + [
            'base' => $project['default_branch'],
        ];

        $this->client->api('pullRequests')->create($project['username'], $project['repository'], $params);
    }

    /**
     * @param  array
     * @return void
     */
    public function deleteFork(array $project)
    {
        $this->client->api('repo')->remove($this->config['bot_username'], $project['repository']);
    }

    /**
     * return \Github\Client
     */
    protected function setClient() :ClientApi
    {
        $client = new ClientApi();
        $client->authenticate($this->config['token'], null, ClientApi::AUTH_URL_TOKEN);

        return $client;
    }
}

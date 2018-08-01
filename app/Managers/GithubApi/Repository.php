<?php

namespace App\Managers\GithubApi;

use App\Managers\GithubApi\Contracts\Driver;

class Repository {

    protected $driver;

    /**
     * @param \App\Managers\GithubApi\Contracts\Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return array
     */
    public function repositories() :array
    {
        return $this->driver->repositories();
    } 

    /**
     * @param  string $username
     * @param  string $repository
     * @return \App\Entities\Repository
     */
    public function show($username, $repository)
    {
        return $this->driver->show($username, $repository);
    } 

    /**
     * @param  string $username
     * @param  string $repository
     * @return string
     */
    public function fork($username, $repository)
    {
        return $this->driver->fork($username, $repository);
    } 

    /**
     * @param  array $project
     * @return void
     */
    public function pullRequest(array $project)
    {
        $this->driver->pullRequest($project);
    }    

    /**
     * @param  array $project
     * @return void
     */
    public function deleteFork(array $project)
    {
        $this->driver->deleteFork($project);
    }  
}

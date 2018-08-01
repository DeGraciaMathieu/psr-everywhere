<?php

namespace App\Managers\GithubApi;

use Illuminate\Support\Manager;

class GithubApiManager extends Manager {

    /**
     * @return \App\Managers\GithubApi\Repository
     */
    public function createClientDriver()
    {
        $config = $this->app['config']['githubapi']['drivers']['client'];

        $driver = new Drivers\Client($config);

        return $this->getRepository($driver);
    }

    /**
     * @param \App\Managers\GithubApi\Contracts\Driver $driver
     * @return \App\Managers\GithubApi\Repository
     */
    protected function getRepository(Contracts\Driver $driver) :Repository
    {
        return new Repository($driver);
    }

    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['githubapi']['driver'];
    }
}

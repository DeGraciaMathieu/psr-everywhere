<?php

namespace App\Entities;

class Repository
{
    protected $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->params['full_name'];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->params['owner']['login'];
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->params['name'];
    }    

    /**
     * @return string
     */
    public function getHtmlUrl()
    {
        return $this->params['html_url'];
    }    

    /**
     * @return string
     */
    public function getDefaultBranch()
    {
        return $this->params['default_branch'];
    }
}

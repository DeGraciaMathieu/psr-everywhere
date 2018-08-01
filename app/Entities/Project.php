<?php

namespace App\Entities;

class Project
{
    protected $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getId()
    {
        return $this->params['id'];
    }

    public function getHash()
    {
        return $this->params['hash'];
    }

    public function getUrl()
    {
        return $this->params['url'];
    }

    public function getPreparedAt()
    {
        return $this->params['prepared_at'];
    }

    public function getStandardisedAt()
    {
        return $this->params['standardised_at'];
    }   

    public function getSuggestedAt()
    {
        return $this->params['suggested_at'];
    }    
    
    public function getCreatedAt()
    {
        return $this->params['created_at'];
    }  

    public function getUpdatedAt()
    {
        return $this->params['updated_at'];
    }                            
}

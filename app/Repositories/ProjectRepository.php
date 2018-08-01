<?php

namespace App\Repositories;

use App\Repositories\Criterias;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Project";
    }

    /**
     * @return array 
     */
    public function presenter()
    {
        return "App\\Presenters\\ProjectPresenter";
    }    

    /**
     * @return array 
     */
    public function waitingForPreparation()
    {
        $this->pushCriteria(new Criterias\WaitingPreparation());

        return $this->get(); 
    }

    /**
     * @return array 
     */
    public function waitingForStandardisation()
    {
        $this->pushCriteria(new Criterias\WaitingStandardisation());

        return $this->get(); 
    }

    /**
     * @return array 
     */
    public function waitingForSuggestion()
    {
        $this->pushCriteria(new Criterias\WaitingSuggestion());

        return $this->get(); 
    }

    /**
     * @return array 
     */
    public function waitingForCleaning()
    {
        $this->pushCriteria(new Criterias\WaitingClean());

        return $this->get();
    }

    /**
     * @param  string $username
     * @param  string $repository
     * @return array
     */
    public function findByCredentials(string $username, string $repository)
    {
        return $this->findWhere([
            'username'=> $username,
            'repository'=> $repository,
        ]);        
    }
}

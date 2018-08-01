<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WaitingStandardisation implements CriteriaInterface {

	/**
	 * @param  \Illuminate\Database\Eloquent\Builder
	 * @param  \Prettus\Repository\Contracts\RepositoryInterface
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereNotNull('prepared_at')->whereNull('standardised_at');

        return $model;
    }
}

<?php

namespace App\Transformers;

use App\Project;
use App\Entities;
use League\Fractal\TransformerAbstract;

/**
 * Class ProjectTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProjectTransformer extends TransformerAbstract
{
    /**
     * Transform the Project entity.
     *
     * @param \App\Entities\Project $model
     * @return array
     */
    public function transform(Project $project)
    {
        return $project->toArray();
    }
}

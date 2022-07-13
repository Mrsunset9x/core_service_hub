<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\SkillVerbRepository;
use App\Models\SkillVerb;
use App\Validators\SkillVerbValidator;

/**
 * Class SkillVerbRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SkillVerbRepositoryEloquent extends BaseRepository implements SkillVerbRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SkillVerb::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

<?php

namespace Modules\License\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\License\Repositories\Interfaces\SkillVerbRepository;
use Modules\License\Models\SkillVerb;
use Modules\License\Validators\SkillVerbValidator;

/**
 * Class SkillVerbRepositoryEloquent.
 *
 * @package namespace Modules\License\Repositories;
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

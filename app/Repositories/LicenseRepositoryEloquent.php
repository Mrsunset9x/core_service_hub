<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\LicenseRepository;
use App\Models\License;
use App\Validators\LicenseValidator;

/**
 * Class LicenseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LicenseRepositoryEloquent extends BaseRepository implements LicenseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return License::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

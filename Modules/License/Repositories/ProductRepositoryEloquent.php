<?php

namespace Modules\License\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\License\Repositories\Interfaces\ProductRepository;
use Modules\License\Models\Product;
use Modules\License\Validators\ProductValidator;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace Modules\License\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

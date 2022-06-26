<?php

namespace Modules\License\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Product.
 *
 * @package namespace Modules\License\Models;
 */
class Product extends Model implements Transformable
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'products';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'thumbnail',
        'name',
        'short_description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'thumbnail' => 'string',
        'name' => 'string',
        'short_description' => 'string'
    ];

    protected $attributes = [
        'thumbnail' => 1,
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'thumbnail' => 'required',
        'name' => 'nullable',
        'short_description' => 'required'
    ];

    public function transform()
    {
        // TODO: Implement transform() method.
    }
}

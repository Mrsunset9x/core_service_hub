<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Exercise
 * @package App\Models
 * @version April 5, 2022, 4:10 pm +07
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $platform_id
 * @property integer $lesson_id
 * @property integer $position
 * @property integer $is_active
 * @property integer $duration
 * @property integer $max_attemps_allowed
 * @property integer $old_game_id
 * @property string $image
 * @property string $video
 * @property string $created_by
 * @property string $sub_description
 */
class Exercise extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'exercises';

    protected $cacheCollection = 'redis.key.educa.core.exercise.info';

    protected $attributes = [
        'old_game_id' => 1,
        'is_active' => true
    ];

    const RANDOM_TYPES = [
      'EXERCISE',
      'HOMEWORK'
    ];

    protected $dates = ['deleted_at'];

    protected bool $is_filter_product = true;


    public $fillable = [
        'name',
        'description',
        'platform_id',
        'lesson_id',
        'position',
        'is_active',
        'duration',
        'max_attemps_allowed',
        'old_game_id',
        'image',
        'created_by',
        'sub_description',
        'product_id',
        'type_id',
        'topic_id',
        'video'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'platform_id' => 'integer',
        'lesson_id' => 'integer',
        'position' => 'integer',
        'is_active' => 'integer',
        'duration' => 'integer',
        'max_attemps_allowed' => 'integer',
        'old_game_id' => 'integer',
        'image' => 'string',
        'created_by' => 'string',
        'sub_description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'platform_id' => 'nullable',
        'lesson_id' => 'nullable',
        'position' => 'nullable',
        'is_active' => 'nullable',
        'duration' => 'nullable',
        'max_attemps_allowed' => 'nullable',
        'old_game_id' => 'nullable',
        'image' => 'nullable',
        'created_by' => 'nullable',
        'sub_description' => 'nullable'
    ];
}

<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Statistic
 * @package App\Models
 * @version April 27, 2021, 12:38 am UTC
 *
 * @property string $target
 * @property string $progress
 */
class Statistic extends Model
{
    use HasFactory;

    public $table = 'tf_progress_new';

    public $timestamps = false;

    public $fillable = [
        'target',
        'progress',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'steamid' => 'string',
        'target' => 'string',
        'progress' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'target' => 'required|string|max:150',
        'progress' => 'nullable|string',
    ];
}

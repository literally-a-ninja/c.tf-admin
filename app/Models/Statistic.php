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

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'target' => 'required|string|max:150',
        'progress' => 'nullable|string',
    ];

    public $table = 'tf_progress_new';

    public $timestamps = false;

    public $fillable = [
        'steamid',
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
        'progress' => 'array',
    ];

    /**
     * TEMPORARY
     */
    public function name()
    {
        $stem = explode(':', $this->target)[1];
        return substr($stem, 0, strlen($stem) - 1);
    }

    /**
     * TEMPORARY
     */
    public function waves()
    {
        $waves = [];
        foreach ($this->progress as $key => $value)
        {
            $array = explode('_', $key);
            if (sizeof($array) == 2 && $array[0] == 'wave')
            {
                $waves[intval($array[1])] = $value;
            }
        }

        return $waves;
    }
}

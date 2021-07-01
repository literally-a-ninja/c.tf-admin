<?php

namespace App\Models;

use App\Database\Schema\Definition;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

/**
 * Class Statistic
 *
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
    public static array $rules = [
        'target' => 'required|string|max:150',
        'progress' => 'required|array',
    ];

    /**
     * DB Table
     *
     * @var string
     */
    public $table = 'tf_progress_new';

    /**
     * Disables DB timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Columns
     *
     * @var string[]
     */
    public $fillable = [
        'steamid',
        'target',
        'progress',
    ];

    /**
     * Classpath of the definition, becomes actual definition on retrieval.
     *
     * @var string|Definition|null
     */
    public mixed $definition = '';

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
     * Called by the service container to setup Eloquent model.
     */
    public static function boot ()
    {
        parent::boot ();

        // Replace respective definition if present.
        static::retrieved (function ($model) {
            if (empty($model->definition)) return;
            $model->definition = App::make ($model->definition)->find ($model->defUnique ());
        });

        // Always set this value on save.
        static::saving (function ($model) {
            $progress = $model->progress;
            $progress['updated'] = time ();
            $model->progress = $progress;
        });
    }

    /**
     * Sets the SteamID column
     */
    public function setPlayer (User $player)
    {
        $this->steamid = $player->steamid;
    }

    /**
     * Returns the "un-database" version of the target.
     *
     *
     * @return string
     */
    public function getIdAttribute () : string
    {
        // E.g., [C:2312] -> 2312
        return $this->defUnique ();
    }

    /**
     * What is used in the definition to discriminate member objects. This method is used
     * to associate the model with the econ def and should be overridden accordingly per model.
     *
     * @return mixed
     */
    public function defUnique () : mixed
    {
        $stem = explode (':', $this->getAttribute ('target'))[1] ?? '';
        if (empty($stem)) return '';
        return intval (substr ($stem, 0, strlen ($stem) - 1));
    }
}

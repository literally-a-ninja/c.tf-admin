<?php

namespace App\Models\Interpretations;

use App\Definitions\EconMission as MissionDef;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Statistic
 *
 * @package App\Models
 * @version April 27, 2021, 12:38 am UTC
 *
 * @property string $target
 * @property array $progress
 */
class Mission extends Statistic
{
    use HasFactory;

    public static function boot ()
    {
        parent::boot ();

        $updateModel = function ($model) {
            $model->getAttribute('progress')['updated'] = now ()->getTimestamp ();
        };

        static:: ($updateModel);
    }

    /**
     * Overrides local object with econ def.
     */
    public function setDef (MissionDef $def)
    {
        $this->target = "[MVMM:{$def->title}]";
    }


    public function markWave (int $n, bool $complete = true) : void
    {
        $this->progress = $this->progress ?? [];

        $progress = $this->progress;
        $progress["wave_{$n}"] = $complete;
        $progress["wave_{$n}_once"] = $complete;

        // Only touch if we're marking as complete.
        if ($complete) {
            $progress["wave_{$n}_duration"] = $this->progress["wave_{$n}_duration"] ?? 999;
        }

        $this->progress = $progress;
    }

    /**
     * Returns an array of completed waves
     */
    public function waves () : array
    {
        if (! $this->progress || ! sizeof ($this->progress)) {
            return [];
        }

        $waves = [];
        foreach ($this->progress as $key => $value) {
            $array = explode ('_', $key);
            if (sizeof ($array) == 1 || $array[0] != 'wave') continue;

            [ $_, $n ] = $array;
            $n = intval ($n);
            $type = $array[2] ?? NULL;

            // We only want to track complete or first complete (I.e., bijective) although
            // the contracker's actual logic is that "complete" -> "first complete" (I.e., implicative)
            switch ($type) {
                //  E.g. wave_1_duration, wave_1_seen
                case NULL:
                case 'first':
                    $truth = (isset($waves[$n]) && $waves[$n]);
                    $waves[$n] = $truth || $value;
                    break;

                //  E.g. wave_1_duration, wave_1_seen, wave_1_watermelon, etc.
                case 'duration':
                case 'seen':
                default:
                    // Nothin'
                    break;
            }
        }

        return $waves;
    }
}

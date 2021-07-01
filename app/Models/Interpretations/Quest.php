<?php

namespace App\Models\Interpretations;

use App\Definitions\EconQuest;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

/**
 * Class Quest
 *
 * @package App\Models
 */
class Quest extends Statistic
{
    use HasFactory;

    /**
     * @var EconQuest|string
     */
    public mixed $definition = EconQuest::class;

    /**
     * @param  array|mixed|string[]  $columns
     * @return Collection|array
     */
    public static function all ($columns = [ '*' ]) : Collection|array
    {
        return Quest::query ()
            ->where ('target', 'LIKE', '[Q:%')
            ->get ();
    }

    /**
     * @param  array  $ids
     * @param  User  $user
     * @return Collection|array
     */
    public static function findByIds (Collection $ids, User $user) : Collection|array
    {
        $ids = $ids->map (fn ($id) => "[Q:$id]");

        return Quest::query ()
            ->whereIn ('target', $ids)
            ->where ('steamid', '=', $user->steamid)
            ->get ();
    }

    public function getObjectivesAttribute () : array
    {
        $points = collect ($this->progress)
            ->filter (fn ($v, $k) => str_starts_with ($k, 'objective'))
            ->mapWithKeys (fn ($v, $k) => [ intval (substr ($k, - 1)) => $v ]);

        return collect ($this->definition->objectives)
            ->map (function ($objective, $k) use ($points) {
                $objective['points'] = $points->get($k, 0);
                return $objective;
            })
            ->toArray ();
    }

    public function getUpdatedAtAttribute () : string
    {
        return $this->progress['updated'] ?? '0';
    }

    public function getTurnedInAttribute () : bool
    {
        return $this->progress['turned'] ?? true;
    }

    public function getNameAttribute ()
    {
        return $this->definition->name;
    }

    public function getTitleAttribute ()
    {
        return $this->definition->title;
    }

    public function getImageAttribute ()
    {
        return $this->definition->image;
    }

    public function getRewardsAttribute ()
    {
        return $this->definition->rewards;
    }
}

<?php

namespace App\Models\Interpretations;

use App\Definitions\EconQuest;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
     * @param  EconQuest[]  $questList
     * @param  User  $user
     * @return Collection|array
     */
    public static function findByEcon (Collection $questList, User $user) : Collection|array
    {
        $foundQuests = Quest::query ()
            ->whereIn ('target', $questList->pluck ('id')->map (fn ($id) => "[Q:$id]"))
            ->where ('steamid', '=', $user->steamid)
            ->get ();

        // Create quest items if they don't already exist.
        $newQuests = collect ();
        $mapOfIds = $foundQuests->mapWithKeys (fn ($quest) => [ $quest->title => true ]);
        if ($mapOfIds->count ()) {
            foreach ($questList->filter (fn ($quest) => ! isset($mapOfIds[$quest->title])) as $quest) {
                $newQuests->push (self::create ([
                    'target' => "[Q:{$quest->id}]",
                    'steamid' => $user->steamid,
                    'progress' => [],
                ]));
            }
        }

        return $foundQuests->merge ($newQuests);
        return [];
    }

    public function getObjectivesAttribute () : array
    {
        $points = collect ($this->progress)
            ->filter (fn ($v, $k) => str_starts_with ($k, 'objective'))
            ->mapWithKeys (fn ($v, $k) => [ intval (substr ($k, - 1)) => $v ]);

        return collect ($this->definition->objectives)
            ->map (function ($objective, $k) use ($points) {
                $objective['points'] = $points->get ($k, 0);
                return $objective;
            })
            ->toArray ();
    }

    public function setObjective ($id, $value) : void
    {
        $progress = $this->progress;

        $progress["objective_$id"] = $value;

        $this->progress = $progress;
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

<?php

namespace App\Models\Interpretations;

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

    public function getAttributeObjectives (): array
    {
        return collect($this->progress)
            ->filter (fn($v, $k) => str_starts_with($k, 'objective'))
            ->mapWithKeys (fn($v, $k) => [intval(substr($k, -1)) => $v])
            ->toArray ();
    }

    public function getAttributeUpdated (): string
    {
        return $this->progress['updated'] ?? '0';
    }

    public function getAttributeTurnedIn ()
    {
        return $this->progress['turned'] ?? true;
    }

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
    public static function findEcon (Collection $ids, User $user) : Collection|array
    {
        $ids = $ids->map (fn ($id) => "[Q:$id]");

        return Quest::query ()
            ->whereIn ('target', $ids)
            ->where ('steamid', '=', $user->steamid)
            ->get ();
    }
}
